<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SubjectType;
use App\Models\Teacher;
use App\Models\TeacherDepartment;
use App\Models\TeacherPosition;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScheduleImport implements ToModel, WithHeadingRow
{
    private $dayId = 1;
    private $timeId = 0;
    private $group = null;

    public function model(array $row)
    {
        $this->timeHandler($row);

        foreach ($row as $k => $v) {
            if (strlen($k) == 5) {
                $this->group = latin_to_cyrillic(strtoupper($k));
            }

            if ($k == 'ponedelnik') {
                $this->group = null;
            }

            if ($this->group && !is_null($v)) {
                if (in_array($v[0], ['1', '2', '3', '4']) && $v[1] == ',') {
                    $weekNumbers = [$v[0], $v[2] == ' ' ? $v[3] : $v[2]];
                    $v = mb_substr($v, 4);
                } elseif (in_array($v[0], ['1', '2', '3', '4']) && $v[1] != ',') {
                    $weekNumbers = [$v[0]];
                    $v = mb_substr($v, 2);
                } else {
                    $weekNumbers = [1, 2, 3, 4];
                }

                foreach ($weekNumbers as $n) {
                    $s = new Schedule();
                    $s->group_id = Group::firstOrCreate(['name' => $this->group], [
                        'education_type_id' => 1,
                        'date_start' => date('Y-m-d', strtotime('yesterday')),
                        'date_end' => date('Y-m-d', strtotime("+48 months")),
                    ])->id;

                    $s->subject_id = $this->importSubjects($v);
                    $s->subject_type_id = $this->importType($v);
                    $s->teacher_id = $this->importTeachers($v);
                    $s->week_number = $n;
                    $s->weekday_id = $this->dayId;
                    $s->building = 0;
                    $s->auditory = 0;
                    $s->subgroup = strlen(strval($k)) != 5 ? 2 : (mb_strlen($v) < 15 ? 1 : null);
                    $s->subject_time_id = $this->timeId;
                    $s->date_start = date('Y-m-d', strtotime('today'));
                    $s->date_end = date('Y-m-d', strtotime('+5 months'));
                    $s->save();
                }
            }
        }
    }

    public function headingRow(): int
    {
        return 2;
    }

    private function makeAbbreviate(string $text)
    {
        $words = preg_split('/[\s-]+/', $text); // Разделяет по - или пробелу

        $firstLetters = array_map(function ($word) {
            $ans = mb_substr($word, 0, 1);

            if (str_contains($word, 'коммуникаций')) {
                $ans .= 'К';
            }

            if ($word == 'и' || $word == 'в') {
                return $word;
            }

            return mb_strtoupper($ans);
        }, $words);

        $acronym = implode("", $firstLetters);

        if (mb_strlen($acronym) == 1) {
            return $text;
        }

        return $acronym;
    }

    private function importTeachers($str)
    {
        $departmentId = null;
        $positionId = null;
        $teacher = mb_substr($str, mb_strpos($str, '),') + 3);

        if (!mb_strpos($str, ',')) {
            //Проверяет есть ли фамилия в строке
            $teacher = '-';
        }

        if (mb_strpos($teacher, ',')) {
            // Если в строке есть кафедра или должность то находит либо создает ее
            $info = mb_split(',', $teacher);

            if (count($info) == 3) {
                $positionId = TeacherPosition::firstOrCreate(['full_name' => ucfirst($info[0])], ['abbreviated_name' => $this->makeAbbreviate($info[0])])->id;
                $departmentId = TeacherDepartment::firstOrCreate(['abbreviated_name' => $info[1]], ['full_name' => $info[1]])->id;
                $teacher = $info[2];
            } else {
                $teacher = $info[1];
            }
        }

        $teacher = mb_split(' ', trim($teacher))[0];
        $teacherModel = Teacher::where('full_name', 'like', $teacher)->first();

        if (is_null($teacherModel)) {
            $teacherModel = Teacher::create([
                'position_id' => $positionId,
                'department_id' => $departmentId,
                'full_name' => $teacher,
            ]);
        }

        if ($teacherModel->full_name == '-' && $teacher != '-') {
            // Если имя преподавателя не было найдено до этого, но сейчас нашлось то обновляет его
            $param = ['full_name' => $teacher];
            $departmentId && $param[] = ['department_id' => $departmentId];
            $positionId && $param[] = ['department_id' => $positionId];

            Teacher::update($param);
        }

        return $teacherModel->id;
    }

    private function importSubjects($str)
    {
        $subject = mb_strpos($str, '(') ? mb_substr($str, 0, mb_strpos($str, '(') - 1) : mb_substr($str, 0, mb_strpos($str, ',') - 1);

        $abbreviated = $this->makeAbbreviate($subject);
        $subjectModel = Subject::where('full_name', $abbreviated)->orWhere('abbreviated_name', $abbreviated)
            ->orWhere('abbreviated_name', $subject)->orWhere('full_name', $subject)->first();

        if (is_null($subjectModel)) {
            return Subject::create(['full_name' => $subject, 'abbreviated_name' => $abbreviated])->id;
        }

        if ($subjectModel->full_name == $abbreviated) {
            $subjectModel->update(['abbreviated_name' => $subjectModel->full_name, 'full_name' => $subject]);
        }

        return $subjectModel->id;
    }

    private function importType($str)
    {
        $type = mb_strpos($str, '(')
        ? trim(mb_substr($str, mb_strpos($str, '(') + 1, mb_strpos($str, ')') - mb_strpos($str, '(') - 1))
        : 'ПЗ';

        $typeModel = SubjectType::firstOrCreate(['abbreviated_name' => $type], [
            'full_name' => $type,
            'exam' => false,
        ]);

        return $typeModel->id;
    }

    private function timeHandler($row)
    {
        if (!is_null($row['ponedelnik'])) {
            $this->dayId++;
        }

        if (!is_null($row['vremya'])) {
            $this->timeId++;

            if ($this->timeId > 6) {
                $this->timeId = 1;
            }
        }
    }
}
