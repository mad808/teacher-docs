# ProTeachers (teacher-docs)

> Ýurdumyzyň ýokary okuw mekdepleriniň professor-mugallymlaryny, talyplaryny we ylmy merkezlerini birleşdirýän sanly bilim platformasy.

ProTeachers is a comprehensive academic portal designed as a "ProDoctorov" style platform for educators, universities, and students in Turkmenistan. It features a full administrative management suite, dedicated teacher portals, public academic catalogs, direct student-to-teacher private messaging, downloadable educational materials, and phone-based SMS OTP authentication.


---

## Key Features

### 1. Public Front-End
- **Educators Directory**: Search and filter teachers by institution, department, academic subject, and years of experience.
- **Detailed Academic Profiles**: View qualifications, degrees, biographies, assigned faculties, ratings, and published materials.
- **Study Materials Catalog**: Browse and download lecture notes, textbooks, and presentations (PDF, DOCX, PPTX, XLSX, ZIP) with automatic download counting.
- **Direct 1-on-1 Chat**: Students can message verified teachers directly with attachment support.
- **Multilingual Support**: Instant locale switching between Turkmen (`tk`), Russian (`ru`), and English (`en`).

### 2. Teacher Portal
- **Personal Dashboard**: Track uploaded documents, total download metrics, student conversations, and rating scores.
- **Profile Management**: Maintain multilingual academic titles, degrees, bio, and associated university / department.
- **Document Manager**: Upload, manage visibility (public/private), and categorize educational materials by subject.

### 3. Administrator Control Panel
- **Dashboard Analytics**: High-level counters for teachers, students, universities, departments, documents, and chats.
- **Faculty & Institutional Hierarchy**: Full CRUD for universities, institutes, departments, and academic lessons.
- **Educator Verification**: Verify credentials and approve teacher accounts.
- **Chat Oversight**: Supervise and moderate conversation threads and messages.
- **Global Settings**: Configure logos, favicons, site titles in 3 languages, contact phone lines, address, and social links (Instagram, TikTok, WhatsApp, IMO).

### 4. Authentication & SMS Gateway Engine
- **Phone-First Auth**: Passwordless or OTP-secured login and registration via phone numbers.
- **SMS Gateway Integration**: Built-in queue (`otp_gateway_messages`) with dedicated API endpoints for Android SMS gateway applications.
- **Developer Bypass**: Automatic master OTP (`240774`) enabled in local/debug environments for rapid testing.

### 5. Performance & Search
- **PostgreSQL Trigram Search**: Indexed using `pg_trgm` GIN operators for instant fuzzy searching across names, titles, and descriptions.

---

## Tech Stack

- **Backend Framework**: Laravel 11.x (PHP 8.2+)
- **Database**: PostgreSQL (with `pg_trgm` extension) / MySQL
- **Frontend**: Blade, Bootstrap 5, Bootstrap Icons, FontAwesome, Select2, Toastr, Swiper
- **Authentication**: Custom Session & SMS OTP Verification System

---

## Database Architecture

- `users`: Core account details, phone, avatar, role (`admin`, `teacher`, `student`), and status.
- `institutions`: Universities, colleges, and research centers with multilingual names and logos.
- `departments`: Academic faculties and departments linked to institutions.
- `lessons`: Academic disciplines, icons, and slug identifiers.
- `teacher_profiles`: Academic titles, degrees, experience, rating, verification flag, and bio.
- `lesson_teacher`: Pivot table linking educators to taught disciplines.
- `documents`: Uploaded academic files, file size, extension, downloads count, and visibility.
- `conversations` & `messages`: Threaded private messaging between students and teachers.
- `otp_codes` & `otp_gateway_messages`: OTP generation, expiry tracking, and outgoing SMS daemon queue.
- `settings`: Site-wide branding, dual phone lines, address, and social links.

---