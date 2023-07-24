<?php

namespace App\Http\Controllers\Swagger\v1;

/**
 * @OA\Info(
 *     title="Schedule API Documentation",
 *     version="1.0.0",
 *     description="АПИ предоставляет доступ к расписанию занятий, экзаменов и их сортировке",
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     ),
 * ),
 * @OA\PathItem(
 *   path="/api/v1/schedule",
 *   description="Расписание"
 * ),
 *
 * @OA\Get(
 *     path="/api/v1/schedule/group",
 *     summary="Получить расписание для группы",
 *     tags={"Расписание"},
 *     @OA\Parameter(
 *         name="Content-Type",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", enum={"application/json"})
 *     ),
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", enum={"application/json"})
 *     ),
 *     @OA\Parameter(
 *         name="group",
 *         in="query",
 *         required=true,
 *         description="Номер группы",
 *         @OA\Schema(type="string", example="ИП291")
 *     ),
 *     @OA\Parameter(
 *         name="subgroup",
 *         in="query",
 *         required=false,
 *         description="Номер подгруппы",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Тип занятия",
 *         @OA\Schema(type="string", example="ЛР")
 *     ),
 *     @OA\Parameter(
 *         name="weeks[]",
 *         in="query",
 *         required=false,
 *         description="Номера недель, для которых нужно получить расписание",
 *         @OA\Schema(type="array",
 *              @OA\Items(
 *                  type="integer",
 *                  enum={1, 2, 3, 4},
 *                  example={1, 2, 3}
 *              )
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="weekdays[]",
 *         in="query",
 *         required=true,
 *         description="Номера дней недели, для которых нужно получить расписание",
 *         @OA\Schema(type="array",
 *             @OA\Items(
 *                  type="integer",
 *                  enum={1, 2, 3, 4, 5, 6, 7},
 *                  example={1, 2, 3}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 @OA\Property(property="schedule", type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=141),
 *                         @OA\Property(property="subject", type="object",
 *                             @OA\Property(property="abbreviated", type="string", example="ООП"),
 *                             @OA\Property(property="full", type="string", example="Объектно-ориентированнное программирование")
 *                         ),
 *                         @OA\Property(property="type", type="object",
 *                             @OA\Property(property="abbreviated", type="string", example="ЛР"),
 *                             @OA\Property(property="full", type="string", example="Лабораторная работа")
 *                         ),
 *                         @OA\Property(property="auditory", type="integer", example=202),
 *                         @OA\Property(property="building", type="string", example="ул. Франциска Скорины 8"),
 *                         @OA\Property(property="weeks", type="string", example="1, 3"),
 *                         @OA\Property(property="subgroup", type="integer", example=2),
 *                         @OA\Property(property="time", type="object",
 *                             @OA\Property(property="number", type="integer", example=5),
 *                             @OA\Property(property="start", type="string", example="16:20"),
 *                             @OA\Property(property="end", type="string", example="18:00")
 *                         ),
 *                         @OA\Property(property="weekday", type="object",
 *                             @OA\Property(property="number", type="integer", example=1),
 *                             @OA\Property(property="name", type="string", example="Понедельник")
 *                         ),
 *                         @OA\Property(property="teacher", type="object",
 *                             @OA\Property(property="id", type="integer", example=2),
 *                             @OA\Property(property="fullName", type="string", example="Петров В. В."),
 *                             @OA\Property(property="department", type="string", example=null),
 *                             @OA\Property(property="position", type="string", example=null)
 *                         )
 *                     )
 *                 ),
 *                 @OA\Property(property="group", type="object",
 *                     @OA\Property(property="id", type="integer", example=9),
 *                     @OA\Property(property="name", type="string", example="ИП291"),
 *                     @OA\Property(property="type", type="object",
 *                         @OA\Property(property="names", type="object",
 *                             @OA\Property(property="abbreviated", type="string", example="ВО"),
 *                             @OA\Property(property="full", type="string", example="Высшее образование")
 *                         ),
 *                         @OA\Property(property="timeType", type="string", example="Заочное")
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Запрошенная группа не найдена"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/v1/schedule/teacher",
 *     summary="Получить расписание для преодователя",
 *     tags={"Расписание"},
 *     @OA\Parameter(
 *         name="Content-Type",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", enum={"application/json"})
 *     ),
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", enum={"application/json"})
 *     ),
 *     @OA\Parameter(
 *         name="teacher",
 *         in="query",
 *         required=true,
 *         description="фио учителя",
 *         @OA\Schema(type="string", example="Игнатьева")
 *     ),
 *     @OA\Parameter(
 *         name="subgroup",
 *         in="query",
 *         required=false,
 *         description="Номер подгруппы",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         required=false,
 *         description="Тип занятия",
 *         @OA\Schema(type="string", example="ПЗ")
 *     ),
 *     @OA\Parameter(
 *         name="weeks[]",
 *         in="query",
 *         required=false,
 *         description="Номера недель, для которых нужно получить расписание",
 *         @OA\Schema(type="array",
 *              @OA\Items(
 *                  type="integer",
 *                  enum={1, 2, 3, 4},
 *                  example={1, 2, 3}
 *              )
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="weekdays[]",
 *         in="query",
 *         required=true,
 *         description="Номера дней недели, для которых нужно получить расписание",
 *         @OA\Schema(type="array",
 *             @OA\Items(
 *                  type="integer",
 *                  enum={1, 2, 3, 4, 5, 6, 7},
 *                  example={1, 2, 3}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 @OA\Property(property="schedule", type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=141),
 *                         @OA\Property(property="subject", type="object",
 *                             @OA\Property(property="abbreviated", type="string", example="ООП"),
 *                             @OA\Property(property="full", type="string", example="Объектно-ориентированнное программирование")
 *                         ),
 *                         @OA\Property(property="type", type="object",
 *                             @OA\Property(property="abbreviated", type="string", example="ЛР"),
 *                             @OA\Property(property="full", type="string", example="Лабораторная работа")
 *                         ),
 *                         @OA\Property(property="auditory", type="integer", example=202),
 *                         @OA\Property(property="building", type="string", example="ул. Франциска Скорины 8"),
 *                         @OA\Property(property="weeks", type="string", example="1, 3"),
 *                         @OA\Property(property="subgroup", type="integer", example=2),
 *                         @OA\Property(property="time", type="object",
 *                             @OA\Property(property="number", type="integer", example=5),
 *                             @OA\Property(property="start", type="string", example="16:20"),
 *                             @OA\Property(property="end", type="string", example="18:00")
 *                         ),
 *                         @OA\Property(property="weekday", type="object",
 *                             @OA\Property(property="number", type="integer", example=1),
 *                             @OA\Property(property="name", type="string", example="Понедельник")
 *                         ),
 *                         @OA\Property(property="group", type="object",
 *                             @OA\Property(property="id", type="integer", example=9),
 *                             @OA\Property(property="name", type="string", example="ИП291"),
 *                             @OA\Property(property="type", type="object",
 *                                 @OA\Property(property="names", type="object",
 *                                     @OA\Property(property="abbreviated", type="string", example="ВО"),
 *                                     @OA\Property(property="full", type="string", example="Высшее образование")
 *                                 ),
 *                                 @OA\Property(property="timeType", type="string", example="Заочное")
 *                             )
 *                         )
 *                     )
 *                 ),
 *                 @OA\Property(property="teacher", type="object",
 *                             @OA\Property(property="id", type="integer", example=2),
 *                             @OA\Property(property="fullName", type="string", example="Петров В. В."),
 *                             @OA\Property(property="department", type="string", example=null),
 *                             @OA\Property(property="position", type="string", example=null)
 *                         )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Запрошенный преподователь не найден"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/v1/schedule/exams",
 *     summary="Получить расписание экзаменов",
 *     description="Возращает расписание экзамнов по фио преподователя или номеру группы",
 *     tags={"Расписание"},
 *     @OA\Parameter(
 *         name="Content-Type",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", enum={"application/json"})
 *     ),
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", enum={"application/json"})
 *     ),
 *     @OA\Parameter(
 *         name="group",
 *         in="query",
 *         description="Номер группы",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *         ),
 *     ),
 *     @OA\Parameter(
 *         name="teacher",
 *         in="query",
 *         description="Фио преподователя",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/ExamResource")
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Unprocessable Entity",
 *     ),
 * )
 *
 * @OA\Schema(
 *     schema="ExamResource",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Exam ID",
 *     ),
 *     @OA\Property(
 *         property="subject",
 *         type="object",
 *         description="Subject information",
 *         @OA\Property(
 *             property="abbreviated",
 *             type="string",
 *             description="Subject abbreviated name",
 *         ),
 *         @OA\Property(
 *             property="full",
 *             type="string",
 *             description="Subject full name",
 *         ),
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="object",
 *         description="Type of exam",
 *         @OA\Property(
 *             property="abbreviated",
 *             type="string",
 *             description="Type abbreviated name",
 *         ),
 *         @OA\Property(
 *             property="full",
 *             type="string",
 *             description="Type full name",
 *         ),
 *     ),
 *     @OA\Property(
 *         property="auditory",
 *         type="integer",
 *         description="Auditory number",
 *     ),
 *     @OA\Property(
 *         property="building",
 *         type="string",
 *         description="Building number",
 *     ),
 *     @OA\Property(
 *         property="teacher",
 *         type="object",
 *         description="Teacher information",
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             description="Teacher ID",
 *         ),
 *         @OA\Property(
 *             property="fullName",
 *             type="string",
 *             description="Teacher full name",
 *         ),
 *         @OA\Property(
 *             property="department",
 *             type="string",
 *             description="Teacher department",
 *         ),
 *         @OA\Property(
 *             property="position",
 *             type="string",
 *             description="Teacher position",
 *         ),
 *     ),
 *     @OA\Property(
 *         property="group",
 *         type="object",
 *         description="Group information",
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             description="Group ID",
 *         ),
 *         @OA\Property(
 *             property="name",
 *             type="string",
 *             description="Group name",
 *         ),
 *         @OA\Property(
 *             property="type",
 *             type="object",
 *             description="Group type",
 *             @OA\Property(
 *                 property="names",
 *                 type="object",
 *                 description="Group type names",
 *                 @OA\Property(
 *                     property="abbreviated",
 *                     type="string",
 *                     description="Group type abbreviated name",
 *                 ),
 *                 @OA\Property(
 *                     property="full",
 *                     type="string",
 *                     description="Group type full name",
 *                 ),
 *             ),
 *             @OA\Property(
 *                 property="timeType",
 *                 type="string",
 *                 description="Group time type",
 *             ),
 *         ),
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date-time",
 *         description="Exam date and time",
 *     ),
 * )
 */

class ScheduleController
{

}
