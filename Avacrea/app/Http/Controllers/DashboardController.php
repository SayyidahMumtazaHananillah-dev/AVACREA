<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Oc;

class DashboardController extends Controller
{
    // DASHBOARD / HOME
    public function index()
    {
        $baseAssets = [
            'color'   => asset('Assets/Character/Base/base color.png'),
            'lineart' => asset('Assets/Character/Base/base lineart.png'),
        ];

        return view('dashboard.index', compact('baseAssets'));
    }


    // PROFILE
    public function profile()
    {
        // Mengambil akun yang sedang login
        $user = Auth::user();

        // Mengambil OC berdasarkan pemiliknya
        $ocs = Oc::where('user_id', $user->id)->get();

        return view('dashboard.profile', compact('user', 'ocs'));
    }


    // EXPLORE
    public function explore(Request $request)
    {
        $search = $request->input('search');

        // Dummy 20 OC orang lain untuk mengisi 5 shaf
        $dummyOcs = collect([
            [
                'id' => 1,
                'name' => 'Kaelen Vane',
                'creator' => 'shadow_ninja',
                'age' => '17 tahun',
                'role' => 'Stealth Rogue',
                'bio' => 'Mantan mata-mata distrik timur yang bergerak di kegelapan malam, handal dengan belati ganda.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 2,
                'name' => 'Aria Lumina',
                'creator' => 'starlight_art',
                'age' => '16 tahun',
                'role' => 'Techno Mage',
                'bio' => 'Pelajar akademi sihir digital yang memadukan mantra rune kuno dengan perangkat synthwave.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 3,
                'name' => 'Riku Phantom',
                'creator' => 'kyo_rei',
                'age' => '18 tahun',
                'role' => 'Netrunner',
                'bio' => 'Hacker lepas yang gemar membobol firewall korporasi sambil mendengarkan musik lofi.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 4,
                'name' => 'Zephyr Caelum',
                'creator' => 'wind_whisper',
                'age' => '19 tahun',
                'role' => 'Aerial Scout',
                'bio' => 'Penjelajah langit kepulauan terapung dengan glider buatan tangan berkecepatan tinggi.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 5,
                'name' => 'Nyx Asteria',
                'creator' => 'valkyrie_01',
                'age' => '20 tahun',
                'role' => 'Astro Vanguard',
                'bio' => 'Penjaga gerbang konstelasi antariksa dengan perisai gravitasi kuantum.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 6,
                'name' => 'Eiden Cross',
                'creator' => 'pixel_master',
                'age' => '17 tahun',
                'role' => 'Mechanic Brawler',
                'bio' => 'Ahli reparasi robot tempur jalanan yang suka memodifikasi lengannya sendiri.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 7,
                'name' => 'Sora Tachibana',
                'creator' => 'anime_freak',
                'age' => '15 tahun',
                'role' => 'Highschool Archer',
                'bio' => 'Anggota klub panahan sekolah yang sering terseret misteri supernatural sepulang kelas.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 8,
                'name' => 'Vespera',
                'creator' => 'goth_queen',
                'age' => '19 tahun',
                'role' => 'Nocturnal Alchemist',
                'bio' => 'Peneliti ramuan terlarang yang hidup di menara jam tua di pinggiran kota.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 9,
                'name' => 'Ren Kazamatsuri',
                'creator' => 'kyo_rei',
                'age' => '18 tahun',
                'role' => 'Kendo Prodigy',
                'bio' => 'Pendekar pedang kayu legendaris yang selalu menantang juara turnamen antar kota.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 10,
                'name' => 'Clover Bell',
                'creator' => 'fluffy_cloud',
                'age' => '14 tahun',
                'role' => 'Potion Brewer',
                'bio' => 'Penyihir pemula yang ramah dan selalu membawa kelinci roh pelindung di tasnya.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 11,
                'name' => 'Dante Morgan',
                'creator' => 'shadow_ninja',
                'age' => '22 tahun',
                'role' => 'Private Detective',
                'bio' => 'Detektif partikelir yang menyelidiki kasus hilangnya avatar di jaringan metaverse.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 12,
                'name' => 'Mira Sunburst',
                'creator' => 'starlight_art',
                'age' => '16 tahun',
                'role' => 'Solar Gunslinger',
                'bio' => 'Penembak jitu gurun neon bertenaga energi matahari murni.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 13,
                'name' => 'Ignis Flare',
                'creator' => 'fire_starter',
                'age' => '18 tahun',
                'role' => 'Flame Striker',
                'bio' => 'Petarung bela diri jalanan yang mengendalikan percikan api dari sepatunya.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 14,
                'name' => 'Glacia Frost',
                'creator' => 'ice_cube',
                'age' => '17 tahun',
                'role' => 'Cryo Sorceress',
                'bio' => 'Gadis pendiam berkekuatan kristal es yang senang mengoleksi miniatur salju.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 15,
                'name' => 'Blitz Dynamo',
                'creator' => 'speedster_99',
                'age' => '19 tahun',
                'role' => 'Thunder Skater',
                'bio' => 'Kurir kilat berseluncur magnetik yang tak pernah telat mengantarkan chip data rahasia.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 16,
                'name' => 'Terra Golem',
                'creator' => 'earth_walker',
                'age' => 'Unknown',
                'role' => 'Ancient Protector',
                'bio' => 'Entitas batu berjiwa lembut yang bertugas menjaga keseimbangan hutan keramat.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 17,
                'name' => 'Chrono Weiss',
                'creator' => 'time_keeper',
                'age' => '17 tahun',
                'role' => 'Time Wanderer',
                'bio' => 'Pelompat waktu yang tersesat di era sekarang dan mencari baterai jam kuantumnya.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 18,
                'name' => 'Lyra Harmonia',
                'creator' => 'melody_maker',
                'age' => '16 tahun',
                'role' => 'Sound Synthesizer',
                'bio' => 'Vokalis band siber bawah tanah yang suaranya bisa memanipulasi gelombang frekuensi.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 19,
                'name' => 'Axel Vance',
                'creator' => 'cyber_punker',
                'age' => '21 tahun',
                'role' => 'Drift Racer',
                'bio' => 'Pembalap liar jalan tol futuristik yang tidak kenal rasa takut.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
            [
                'id' => 20,
                'name' => 'Selene Nocturne',
                'creator' => 'lunar_eclipse',
                'age' => '18 tahun',
                'role' => 'Moon Priestess',
                'bio' => 'Penjaga kuil bulan yang memancarkan aura ketenangan dan perlindungan bagi kawan.',
                'thumbnail' => asset('Assets/Character/Base/base color.png')
            ],
        ]);

        // Filter berdasarkan username atau nama OC
        if (!empty($search)) {
            $filteredOcs = $dummyOcs->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['creator']), strtolower($search)) ||
                       str_contains(strtolower($item['name']), strtolower($search));
            });
        } else {
            $filteredOcs = $dummyOcs;
        }

        return view('dashboard.explore', [
            'ocs' => $filteredOcs,
            'search' => $search
        ]);
    }


    // LOGOUT
    public function logout(Request $request)
    {
        return redirect()->route('dashboard');
    }
}
