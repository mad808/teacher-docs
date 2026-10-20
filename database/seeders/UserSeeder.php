<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Institution;
use App\Models\Lesson;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['phone' => '+99362240774'],
            [
                'name' => 'Eziz Sopyyev',
                'email' => 'admin@proteachers.edu',
                'password' => Hash::make('admin123'),
                'phone_verified_at' => now(),
                'role' => 'admin',
                'status' => 1,
            ]
        );

        User::updateOrCreate(
            ['phone' => '+99365000002'],
            [
                'name' => 'Aman Amanow',
                'email' => 'aman@proteachers.edu',
                'password' => Hash::make('password'),
                'phone_verified_at' => now(),
                'role' => 'student',
                'status' => 1,
            ]
        );

        $teacherUser = User::updateOrCreate(
            ['phone' => '+99365000003'],
            [
                'name' => 'Mahri Annavewa',
                'email' => 'mahri@proteachers.edu',
                'password' => Hash::make('password'),
                'phone_verified_at' => now(),
                'role' => 'teacher',
                'status' => 1,
            ]
        );

        $institution = Institution::firstOrCreate(
            ['slug' => 'magtymguly-turkmen-state-university'],
            [
                'name_tk' => 'Magtymguly adyndaky Türkmen döwlet uniwersiteti',
                'name_ru' => 'Туркменский государственный университет имени Махтумкули',
                'name_en' => 'Magtymguly Turkmen State University',
                'type' => 'university',
                'city' => 'Aşgabat',
                'address_tk' => 'Aşgabat ş., Saparmyrat Türkmenbaşy şaýoly, 31',
                'address_ru' => 'г. Ашхабад, проспект Сапармурата Туркменбаши, 31',
                'address_en' => 'Ashgabat, Saparmurat Turkmenbashi avenue, 31',
                'phone' => '+99312942000',
                'website' => 'https://tdu.edu.tm',
                'status' => 1,
            ]
        );

        $department = Department::firstOrCreate(
            [
                'institution_id' => $institution->id,
                'slug' => 'maglumat-tehnologiyalary'
            ],
            [
                'name_tk' => 'Maglumat tehnologiýalary kafedrasy',
                'name_ru' => 'Кафедра информационных технологий',
                'name_en' => 'Department of Information Technology',
                'status' => 1,
            ]
        );

        $lessonMath = Lesson::firstOrCreate(
            ['slug' => 'matematika'],
            [
                'name_tk' => 'Ýokary matematika',
                'name_ru' => 'Высшая математика',
                'name_en' => 'Higher Mathematics',
                'icon' => 'bi-calculator-fill',
                'status' => 1,
            ]
        );

        $lessonCS = Lesson::firstOrCreate(
            ['slug' => 'programmirleme'],
            [
                'name_tk' => 'Programmirleme we IT',
                'name_ru' => 'Программирование и IT',
                'name_en' => 'Programming and IT',
                'icon' => 'bi-laptop-fill',
                'status' => 1,
            ]
        );

        $profile = TeacherProfile::updateOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'institution_id' => $institution->id,
                'department_id' => $department->id,
                'title_tk' => 'Uly mugallym',
                'title_ru' => 'Старший преподаватель',
                'title_en' => 'Senior Lecturer',
                'degree_tk' => 'Fizika-matematika ylymlarynyň kandidaty',
                'degree_ru' => 'Кандидат физико-математических наук',
                'degree_en' => 'Candidate of Physical and Mathematical Sciences',
                'experience_years' => 8,
                'bio_tk' => '8 ýyllyk ylmy we mugallymçylyk tejribesi bolan ýokary derejeli hünärmen. Talyplara ýokary matematika we maglumat ulgamlary boýunça ders berýär.',
                'bio_ru' => 'Специалист с 8-летним стажем преподавания и научной работы. Преподает высшую математику и современные информационные системы.',
                'bio_en' => 'Professional educator with 8 years of teaching and scientific experience. Teaches higher mathematics and modern information systems.',
                'education_center_tk' => 'Ylymlar Akademiýasy, Tehnologiýalar Merkezi',
                'education_center_ru' => 'Академия наук, Центр технологий',
                'education_center_en' => 'Academy of Sciences, Technology Center',
                'rating' => 5.00,
                'reviews_count' => 14,
                'is_verified' => true,
                'status' => 1,
            ]
        );

        $profile->lessons()->sync([$lessonMath->id, $lessonCS->id]);
    }
}