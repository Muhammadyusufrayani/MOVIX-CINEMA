<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Film;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds with currently released films in cinemas.
     */
    public function run(): void
    {
        // 1. Sedang Tayang (Now Showing in Indonesian Cinemas)
        $nowShowingFilms = [
            [
                'title' => 'Gladiator II',
                'slug' => 'gladiator-ii',
                'genre' => 'Aksi, Epik, Sejarah, Drama',
                'duration' => 148,
                'rating' => 8.6,
                'age_rating' => '17+',
                'director' => 'Ridley Scott',
                'cast' => 'Paul Mescal, Pedro Pascal, Denzel Washington, Connie Nielsen, Joseph Quinn',
                'synopsis' => 'Bertahun-tahun setelah menyaksikan kematian pahlawan legendaris Maximus di tangan pamannya, Lucius (Paul Mescal) terpaksa memasuki Colosseum setelah rumahnya ditaklukkan oleh kaisar-kaisar tiran yang memimpin Roma dengan tangan besi. Dengan amarah di hatinya dan masa depan kekaisaran yang dipertaruhkan, Lucius harus melihat masa lalunya untuk menemukan kekuatan dan kehormatan demi mengembalikan kejayaan Roma kepada rakyatnya.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/2cxhvwyEwRlysAmRH4iodkvo0z5.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/euYIwmwkmz95mnXvufEmbL69ovr.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=4rgYUipGJNo',
                'status' => 'now_showing',
                'release_date' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Wicked',
                'slug' => 'wicked',
                'genre' => 'Fantasi, Musikal, Romantis, Petualangan',
                'duration' => 160,
                'rating' => 8.7,
                'age_rating' => '13+',
                'director' => 'Jon M. Chu',
                'cast' => 'Cynthia Erivo, Ariana Grande, Jonathan Bailey, Michelle Yeoh, Jeff Goldblum',
                'synopsis' => 'Kisah tak terungkap dari para penyihir legendaris tanah Oz: Elphaba, seorang wanita muda berkulit hijau yang kerap disalahpahami, dan Glinda, gadis berkarisma yang dipenuhi privilese dan popularitas. Saat bertemu sebagai mahasiswi di Universitas Shiz, keduanya menjalin persahabatan tak terduga namun mendalam, hingga perjumpaan dengan The Wizard of Oz mengubah takdir hidup mereka ke jalan yang sangat berbeda.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/xDGbZ0JJ3mYaGKy4Nzd9Kph6M9L.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/uVl9rwqgY6e8uCwbq11k62gQpW8.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=6COmYeLsz4c',
                'status' => 'now_showing',
                'release_date' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Bila Esok Ibu Tiada',
                'slug' => 'bila-esok-ibu-tiada',
                'genre' => 'Drama, Keluarga, Mengharukan',
                'duration' => 104,
                'rating' => 8.9,
                'age_rating' => '13+',
                'director' => 'Rudi Soedjarwo',
                'cast' => 'Christine Hakim, Slamet Rahardjo, Adinia Wirasti, Fedi Nuril, Amanda Manopo, Yasmin Napper',
                'synopsis' => 'Kisah menyentuh hati tentang seorang ibu bernama Rahmi yang mendedikasikan hidupnya demi kebahagiaan keempat anaknya setelah kepergian sang suami tercinta, Haryo. Namun, seiring berjalannya waktu, kesibukan dan konflik antar-saudara membuat rumah semakin dingin. Ketika sang ibu mendadak jatuh sakit, anak-anaknya dihadapkan pada ketakutan terbesar: siapkah mereka jika esok hari sang ibu benar-benar tiada?',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/dUVhcxEPaTw8ns1Q7NgKGdy5ag4.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/dUVhcxEPaTw8ns1Q7NgKGdy5ag4.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=8Vz3k6lKzUQ',
                'status' => 'now_showing',
                'release_date' => Carbon::now()->subDays(4),
            ],
            [
                'title' => 'Moana 2',
                'slug' => 'moana-2',
                'genre' => 'Animasi, Petualangan, Keluarga, Komedi',
                'duration' => 100,
                'rating' => 8.8,
                'age_rating' => 'SU',
                'director' => 'David G. Derrick Jr.',
                'cast' => 'Auli\'i Cravalho, Dwayne Johnson, Alan Tudyk, Temuera Morrison, Nicole Scherzinger',
                'synopsis' => 'Setelah tiga tahun sejak petualangan pertamanya, Moana menerima panggilan tak terduga dari para leluhur penunjuk jalannya. Bersama Maui dan kru pelaut baru yang unik, Moana harus mengarungi perairan berbahaya di pelosok Oceania yang telah lama hilang demi mematahkan kutukan dewa Nalo dan menghubungkan kembali seluruh suku pulau.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/1sQA7lfcF9yUyoLYC0e6Zo3jmxE.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/tElnmtQ6yz1PjN1kePNl8yMSb59.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=hDZ7y8RP5HE',
                'status' => 'now_showing',
                'release_date' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Red One',
                'slug' => 'red-one',
                'genre' => 'Aksi, Petualangan, Komedi, Fantasi',
                'duration' => 123,
                'rating' => 8.1,
                'age_rating' => '13+',
                'director' => 'Jake Kasdan',
                'cast' => 'Dwayne Johnson, Chris Evans, J.K. Simmons, Lucy Liu, Kiernan Shipka',
                'synopsis' => 'Ketika Sinterklas (dengan nama sandi: Red One) diculik secara misterius dari Kutub Utara beberapa hari sebelum Malam Natal, Kepala Keamanan E.L.F. Callum Drift harus merekrut pemburu hadiah paling ulung dan licik di dunia, Jack O\'Malley, untuk melacak jejak penculik dalam petualangan global beroktan tinggi.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/cdqLnri3NEGcmfnqwk2TSIYtddg.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/cjEcqdRdPQJhYm3btAc0Pgn4By1.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=U8XH3W0c9ic',
                'status' => 'now_showing',
                'release_date' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Venom: The Last Dance',
                'slug' => 'venom-the-last-dance',
                'genre' => 'Aksi, Sci-Fi, Petualangan',
                'duration' => 109,
                'rating' => 8.3,
                'age_rating' => '13+',
                'director' => 'Kelly Marcel',
                'cast' => 'Tom Hardy, Chiwetel Ejiofor, Juno Temple, Rhys Ifans, Stephen Graham',
                'synopsis' => 'Eddie Brock dan Venom kini menjadi buronan yang dikejar oleh militer manusia serta makhluk mengerikan ciptaan Knull dari planet asal simbiot. Terpojok di Las Vegas, ikatan persahabatan mereka diuji hingga batas maksimal dalam pertempuran terakhir yang akan mengubah segalanya.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/aosm8NMQ3UyoBVpS2tmZCQmCaXk.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/3V4kLQg0kSqPLctI5ziYWMEAZYF.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=__2bjWbetsA',
                'status' => 'now_showing',
                'release_date' => Carbon::now()->subDays(18),
            ],
            [
                'title' => 'The Wild Robot',
                'slug' => 'the-wild-robot',
                'genre' => 'Animasi, Sci-Fi, Petualangan, Keluarga',
                'duration' => 102,
                'rating' => 8.8,
                'age_rating' => 'SU',
                'director' => 'Chris Sanders',
                'cast' => 'Lupita Nyong\'o, Pedro Pascal, Kit Connor, Bill Nighy, Stephanie Hsu',
                'synopsis' => 'Robot penolong ROZZUM unit 7134 alias Roz terdampar di sebuah pulau liar tak berpenghuni setelah kapal kargonya karam. Roz belajar beradaptasi dengan hukum alam rimba dan secara tak sengaja menjadi sosok ibu angkat bagi seekor anak angsa yatim piatu bernama Brightbill.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/9w0Vh9eizfBXrcomiaFWTIPdboo.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/mQZJoIhTEk2k4zWdKqV91G3e1V9.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=67vbA5ZJdKQ',
                'status' => 'now_showing',
                'release_date' => Carbon::now()->subDays(25),
            ],
        ];

        // 2. Segera Hadir (Upcoming Releases)
        $upcomingFilms = [
            [
                'title' => 'Mufasa: The Lion King',
                'slug' => 'mufasa-the-lion-king',
                'genre' => 'Animasi, Petualangan, Drama, Musikal',
                'duration' => 118,
                'rating' => 8.7,
                'age_rating' => 'SU',
                'director' => 'Barry Jenkins',
                'cast' => 'Aaron Pierre, Kelvin Harrison Jr., Seth Rogen, Billy Eichner, Beyoncé',
                'synopsis' => 'Mengangkat kisah asal-usul Mufasa, seekor anak singa yatim piatu yang tersesat di alam liar hingga dipertemukan dengan Taka, pangeran singa berdarah bangsawan. Persaudaraan mereka yang erat menjadi cikal bakal terbentuknya Pride Lands sebelum intrik kekuasaan memisahkan mereka.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/lurEK87Luk8Eb2Pr0Fs4BY1qWfl.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/tElnmtQ6yz1PjN1kePNl8yMSb59.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=o17MF9vnabg',
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addDays(25),
            ],
            [
                'title' => 'Sonic the Hedgehog 3',
                'slug' => 'sonic-the-hedgehog-3',
                'genre' => 'Aksi, Komedi, Petualangan, Sci-Fi',
                'duration' => 110,
                'rating' => 8.5,
                'age_rating' => 'SU',
                'director' => 'Jeff Fowler',
                'cast' => 'Ben Schwartz, Jim Carrey, Keanu Reeves, Idris Elba, James Marsden',
                'synopsis' => 'Sonic, Knuckles, dan Tails harus menghadapi ancaman baru paling berbahaya dari masa lalu Dr. Robotnik: Shadow the Hedgehog (disuarakan Keanu Reeves), makhluk super misterius dengan kekuatan teleportasi chaos control yang tak tertandingi.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/d8Ryb8AunYAuycVKDp5H9W6oQ8q.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/cjEcqdRdPQJhYm3btAc0Pgn4By1.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=qSu6i2iFMO0',
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addDays(35),
            ],
            [
                'title' => 'Captain America: Brave New World',
                'slug' => 'captain-america-brave-new-world',
                'genre' => 'Aksi, Sci-Fi, Petualangan',
                'duration' => 135,
                'rating' => 8.2,
                'age_rating' => '13+',
                'director' => 'Julius Onah',
                'cast' => 'Anthony Mackie, Harrison Ford, Danny Ramirez, Liv Tyler, Giancarlo Esposito',
                'synopsis' => 'Sam Wilson secara resmi bertugas sebagai Captain America baru di panggung global. Ketika Presiden Thaddeus Ross berniat menjadikan Captain America posisi militer resmi, konspirasi pembunuhan dan kemunculan monster raksasa Red Hulk mengancam kehancuran perdamaian dunia.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/z7ryB0p63jMtz212E53F97n3R8V.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/euYIwmwkmz95mnXvufEmbL69ovr.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=1pHDWnXmK7Y',
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addMonths(2),
            ],
            [
                'title' => 'Mission: Impossible - The Final Reckoning',
                'slug' => 'mission-impossible-the-final-reckoning',
                'genre' => 'Aksi, Thriller, Petualangan',
                'duration' => 165,
                'rating' => 8.9,
                'age_rating' => '13+',
                'director' => 'Christopher McQuarrie',
                'cast' => 'Tom Cruise, Hayley Atwell, Ving Rhames, Simon Pegg, Esai Morales, Pom Klementieff',
                'synopsis' => 'Klimaks akhir dari misi hidup dan mati Ethan Hunt bersama tim IMF untuk melacak dan memusnahkan The Entity—kecerdasan buatan maha kuat yang bersembunyi di dalam kapal selam nuklir Sevastopol di dasar samudra es Arktik.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/z53t76t4peoA51FthVNDkfcddj0.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/uVl9rwqgY6e8uCwbq11k62gQpW8.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=NOhDyUmT9z0',
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addMonths(5),
            ],
            [
                'title' => 'Avatar: Fire and Ash',
                'slug' => 'avatar-fire-and-ash',
                'genre' => 'Aksi, Petualangan, Sci-Fi',
                'duration' => 190,
                'rating' => 8.9,
                'age_rating' => '13+',
                'director' => 'James Cameron',
                'cast' => 'Sam Worthington, Zoe Saldana, Sigourney Weaver, Oona Chaplin, Michelle Yeoh',
                'synopsis' => 'Kelanjutan epik James Cameron di planet Pandora. Jake Sully dan Neytiri kini menghadapi klan Na\'vi baru yang kejam dan dipenuhi dendam bernama Ash People (Suku Abu) pimpinan Varang di wilayah vulkanik ekstrem.',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/7a7nC89a4B5s3j89D26b5c3y7N9.jpg',
                'banner_url' => 'https://image.tmdb.org/t/p/original/3V4kLQg0kSqPLctI5ziYWMEAZYF.jpg',
                'trailer_url' => null,
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addMonths(7),
            ],
        ];

        // Seed Studios & Schedules
        $studios = [
            ['name' => 'Studio 1 - Regular 2D', 'price' => 45000],
            ['name' => 'Studio 2 - IMAX 3D Laser', 'price' => 75000],
            ['name' => 'Studio Premiere - Velvet VIP', 'price' => 100000],
        ];

        $times = ['12:30', '15:15', '18:00', '20:45'];

        $today = Carbon::today();
        $dates = [
            $today->copy(),
            $today->copy()->addDay(),
            $today->copy()->addDays(2),
        ];

        foreach ($nowShowingFilms as $data) {
            $film = Film::create($data);

            // Generate schedules for 3 days
            foreach ($dates as $dateIndex => $scheduleDate) {
                foreach ($studios as $studioIndex => $studio) {
                    $assignedTime = $times[($dateIndex + $studioIndex) % count($times)];

                    $schedule = Schedule::create([
                        'film_id' => $film->id,
                        'studio_name' => $studio['name'],
                        'date' => $scheduleDate->format('Y-m-d'),
                        'time' => $assignedTime,
                        'price' => $studio['price'],
                        'total_seats' => 48,
                    ]);

                    // Seed some booked seats for realistic cinema status
                    if ($schedule->id % 2 === 1) {
                        $dummySeats = ['A3', 'A4', 'B5', 'C4', 'C5', 'D6'];
                        $booking = Booking::create([
                            'booking_code' => 'MVX-' . strtoupper(Str::random(8)),
                            'schedule_id' => $schedule->id,
                            'customer_name' => 'Budi Santoso',
                            'customer_email' => 'budi@example.com',
                            'customer_phone' => '081234567890',
                            'total_seats' => count($dummySeats),
                            'total_price' => count($dummySeats) * $schedule->price,
                            'status' => 'confirmed',
                        ]);

                        foreach ($dummySeats as $seat) {
                            BookingSeat::create([
                                'booking_id' => $booking->id,
                                'schedule_id' => $schedule->id,
                                'seat_number' => $seat,
                            ]);
                        }
                    }
                }
            }
        }

        // Seed Upcoming Films
        foreach ($upcomingFilms as $data) {
            Film::create($data);
        }
    }
}
