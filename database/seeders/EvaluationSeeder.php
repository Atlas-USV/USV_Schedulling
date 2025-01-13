<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
<<<<<<< Updated upstream
        // $subject = Subject::first();
        // $teacher = User::first();

        // Evaluation::create([
        //     'subject_id' => $subject->id,
        //     'teacher_id' => $teacher->id,
        //     'type' => 'exam',
=======
        // // Creează examene
        // Evaluation::insert([
        //     [
        //         'description' => 'Final exam for subject 1.',
        //         'end_time' => '2024-12-15 11:00:00',
        //         'exam_date' => '2024-12-15',
        //         'group_id' => 1,
        //         'other_examinators' => json_encode(["2", "3"]),
        //         'room_id' => 1,
        //         'speciality_id' => 1,
        //         'start_time' => '2024-12-15 09:00:00',
        //         'subject_id' => 1,
        //         'teacher_id' => 1,
        //         'type' => 'exam', // Schimbat din Written
        //         'year_of_study' => 1
        //     ],
        //     [
        //         'description' => 'Midterm exam for subject 2.',
        //         'end_time' => '2024-12-20 12:00:00',
        //         'exam_date' => '2024-12-20',
        //         'group_id' => 1,
        //         'other_examinators' => json_encode(["4"]),
        //         'room_id' => 2,
        //         'speciality_id' => 2,
        //         'start_time' => '2024-12-20 10:00:00',
        //         'subject_id' => 2,
        //         'teacher_id' => 1,
        //         'type' => 'colloquium', // Schimbat din Oral
        //         'year_of_study' => 2
        //     ],
        //     [
        //         'description' => 'Practical evaluation for subject 3.',
        //         'end_time' => '2025-01-10 10:00:00',
        //         'exam_date' => '2025-01-10',
        //         'group_id' => 1,
        //         'other_examinators' => json_encode(["5"]),
        //         'room_id' => 2,
        //         'speciality_id' => 3,
        //         'start_time' => '2025-01-10 08:00:00',
        //         'subject_id' => 3,
        //         'teacher_id' => 1,
        //         'type' => 'project', // Schimbat din Practical
        //         'year_of_study' => 3
        //     ],

        //     // Past exams
        //     [
        //         'description' => 'Past final exam for subject 1.',
        //         'end_time' => '2023-05-15 11:00:00',
        //         'exam_date' => '2023-05-15',
        //         'group_id' => 1,
        //         'other_examinators' => json_encode(["2"]),
        //         'room_id' => 1,
        //         'speciality_id' => 1,
        //         'start_time' => '2023-05-15 09:00:00',
        //         'subject_id' => 1,
        //         'teacher_id' => 1,
        //         'type' => 'exam',
        //         'year_of_study' => 1
        //     ],
        //     [
        //         'description' => 'Past midterm exam for subject 2.',
        //         'end_time' => '2023-06-20 12:00:00',
        //         'exam_date' => '2023-06-20',
        //         'group_id' => 1,
        //         'other_examinators' => json_encode(["3"]),
        //         'room_id' => 2,
        //         'speciality_id' => 2,
        //         'start_time' => '2023-06-20 10:00:00',
        //         'subject_id' => 2,
        //         'teacher_id' => 1,
        //         'type' => 'colloquium',
        //         'year_of_study' => 2
        //     ],
        //     [
        //         'description' => 'Past practical exam for subject 3.',
        //         'end_time' => '2023-07-10 10:00:00',
        //         'exam_date' => '2023-07-10',
        //         'group_id' => 1,
        //         'other_examinators' => json_encode(["4"]),
        //         'room_id' => 2,
        //         'speciality_id' => 3,
        //         'start_time' => '2023-07-10 08:00:00',
        //         'subject_id' => 3,
        //         'teacher_id' => 1,
        //         'type' => 'project',
        //         'year_of_study' => 3
        //     ],
>>>>>>> Stashed changes
        // ]);
    }
}
