<?php

namespace App\Http\Controllers;
use App\Models\darren;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // Import session

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard()
{
    // Cek apakah pengguna sudah login
    $id_level = session()->get('id_level');
    
    if (!$id_level) {
        return redirect()->route('login');
    }

    $model = new darren();

    $userId = session()->get('id_user');
    $username = session()->get('username');

    // Ambil data statistik dan convert ke array
    $totalAlumni = $model->getTotalAlumni();
    $alumniByJurusan = $model->getAlumniCountByJurusan()->toArray(); // Convert ke array
    $alumniList = $model->getAlumniList(); // Jika butuh array juga, tambahkan ->toArray()

    $data = [
        'username' => $username,
        'totalAlumni' => $totalAlumni,
        'alumniByJurusan' => $alumniByJurusan,
        'alumniList' => $alumniList,
    ];

    $where = ['id_setting' => 1];
    $data['darren2'] = $model->getWhere('setting', $where);

    $id_user = session()->get('id_user');
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Masuk Menu Dashboard',
        'time' => now()->toDateTimeString()
    ];

    $model->logActivity($activityLog);

    echo view('header', $data);
    echo view('menu', $data);
    echo view('dashboard', $data);
    echo view('footer');
}

public function user()
{
    // Check user level from session
    $id_level = Session::get('id_level');
    
    if (!$id_level) {
        return redirect()->to('home/login');
    } elseif ($id_level != 1) {
        return redirect()->to('home/error404');
    }

    // Fetch data from the model
    $model = new darren();
    $data['darren'] = $model->tampil2('user'); // Adjust this if using Eloquent
    $data['level'] = $id_level; // You already have the level from the session

    // Get settings data
    $data['darren2'] = $model->getwhere('setting', ['id_setting' => 1]); // Adjust this if using Eloquent

    // Log user activity
    $id_user = Session::get('id');
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Masuk Menu User',
        'time' => now() // Using Carbon's now() for the current timestamp
    ];
    $model->logActivity($activityLog); // Adjust this if using Eloquent

    echo view('header', $data); // Adjust to your actual view name
    echo view('menu', $data); // Adjust to your actual view name
    echo view('user', $data); // Adjust to your actual view name
    echo view('footer'); // Adjust to your actual view name
}

    
    public function alumnidata()
    {
        // Check if user level exists in the session
        $id_level = Session::get('id_level');	
        if (!$id_level) {
            return redirect()->route('login'); // Redirect to the login route
        }
    
        $model = new darren(); // Initialize your model
    
        // Fetch alumni data
        $data['darren'] = $model->tampil2('alumni');
    
        // Fetch setting data
        $where = ['id_setting' => 1];
        $data['darren2'] = $model->getwhere('setting', $where);
    
        // Log user activity
        $id_user = Session::get('id');
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Masuk Menu Data Alumni',
            'time' => now() // Use Laravel's now() helper for the current timestamp
        ];
        $model->logActivity($activityLog); // Ensure this method is defined in your model
    
        // Using echo view to render the views
        echo view('header', $data); // Render the header view
        echo view('menu', $data);    // Render the menu view
        echo view('alumnidata', $data); // Render the alumni data view
        echo view('footer');          // Render the footer view
    }
    

    public function alumni()
{
    $id_level = Session::get('id_level'); // Retrieve the user level from the session

    // Check if user is logged in and has the appropriate level
    if (!$id_level) {
        return redirect()->route('login'); // Adjust to your login route
    }

    $model = new darren(); // Initialize your model

    // Fetch alumni data
    $data['darren'] = $model->tampil('alumni');

    // Fetch setting data
    $where = ['id_setting' => 1];
    $data['darren2'] = $model->getwhere('setting', $where);

    // Log user activity
    $id_user = Session::get('id');
    $activityLog = [
        'id_user' => $id_user,
        'activity' => 'Masuk Menu Alumni',
        'time' => now() // Use Laravel's now() helper for the current timestamp
    ];
    $model->logActivity($activityLog); // Ensure this method is defined in your model

    // Using echo view to render the views
    echo view('header', $data); // Render the header view
    echo view('menu', $data);    // Render the menu view
    echo view('alumni', $data);  // Render the alumni view
    echo view('footer');          // Render the footer view
}

public function adduser()
{
    // Check the user level from session
    $id_level = Session::get('id_level');

    // Redirect if the user is not logged in or if they are not an admin
    if (!$id_level) {
        return redirect()->to('home/login');
    } elseif ($id_level != 1) {
        return redirect()->to('home/error404');
    }

    // Fetch the settings data
    $model = new darren();
    $data['darren2'] = $model->getwhere('setting', ['id_setting' => 1]);

    // Return the views
    return view('header', $data)
        ->with('menu', view('menu', $data))
        ->with('adduser', view('adduser'))
        ->with('footer', view('footer'));
}

    public function addalumni()
{
    // Check user level from session
    $id_level = Session::get('id_level');

    // Redirect if the user is not logged in or not an admin
    if (!$id_level) {
        return redirect()->to('home/login');
    } elseif ($id_level != 1) {
        return redirect()->to('home/error404');
    }

    // Fetch settings data
    $model = new darren();
    $data['darren2'] = $model->getwhere('setting', ['id_setting' => 1]); // Adjust to your model's method

    // Return the views
    echo view('header', $data); // Render the header view
    echo view('menu', $data);    // Render the menu view
    echo view('addalumni', $data);  // Render the alumni view
    echo view('footer');          // Render the footer view
}
    public function aksiAddUser(Request $request)
    {
        $model = new darren();
        $data = [
            'username' => $request->input('username'),
            // 'password' => bcrypt($request->input('password')),
            // 'id_level' => $request->input('id_level')
        ];

        $model->tambah('user', $data);

        return redirect('user')->with('success', 'User berhasil ditambahkan!');
    }

    public function editUser($id_user)
    {
        // Get the user data by ID
        $model = new darren();
        $user = $model->getwhere('user', ['id_user' => $id_user]);
    
        // Return the views
        return view('header')
            ->with('menu', view('menu'))
            ->with('edituser', view('edituser', compact('user')))
            ->with('footer', view('footer'));
    }

    public function updateUser(Request $request, $id_user)
    {
        $model = new darren();
        $data = [
            'username' => $request->input('username'),
           
        ];

        $model->edit('user',['id_user' => $id_user], $data);

        return redirect('user')->with('success', 'User updated successfully');
    }

    public function deleteUser($id_user)
    {
        $model = new darren();
        $model->hapus('user',['id_user' => $id_user]);

        return redirect('user')->with('success', 'User deleted successfully');
    }

    public function login()
	{
		$model = new darren();
		$where = array('id_setting' => 1);
		$data['darren2'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('login',$data);
	}

    public function aksi_login(Request $request)
    {
        // Mengakses input dari request
        $name = $request->input('username');
        $pw = $request->input('password');
        $captchaResponse = $request->input('g-recaptcha-response');
        $backupCaptcha = $request->input('backup_captcha');
    
        // Secret key untuk Google reCAPTCHA
        $secretKey = '6LdFhCAqAAAAAM1ktawzN-e2ebDnMnUQgne7cy53'; 
        $recaptchaSuccess = false;
    
        // Membuat instance model
        $captchaModel = new darren();  // Asumsi model darren sudah di-import di bagian atas controller
    
        if ($this->isInternetAvailable()) {
            // Verifikasi Google reCAPTCHA
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
            $responseKeys = json_decode($response, true);
            $recaptchaSuccess = $responseKeys["success"];
        }
        
        if ($recaptchaSuccess) {
            // Validasi username dan password tanpa hash
            $model = new darren();
            $user = $model->getWhere('user', ['username' => $name]); // Dapatkan pengguna berdasarkan username
    
            if ($user && $user->password === $pw) { // Verifikasi password tanpa hash
                // Set session
                session()->put('username', $user->username);
                session()->put('id_user', $user->id_user);
                session()->put('id_level', $user->id_level);
    
                // Catat aktivitas login (opsional)
                // $activityLog = [
                //     'id_user' => session()->get('id_user'),
                //     'activity' => 'Login',
                //     'time' => now()
                // ];
                // $model->logActivity($activityLog);
    
                return redirect()->to('dashboard');
            } else {
                return redirect()->to('login')->with('error', 'Invalid username or password.');
            }
        } else {
            // Validasi backup CAPTCHA jika reCAPTCHA gagal atau tidak tersedia
            $storedCaptcha = session()->get('captcha_code'); // Ambil CAPTCHA yang tersimpan di session
    
            if ($storedCaptcha !== null) {
                if ($storedCaptcha === $backupCaptcha) {
                    // CAPTCHA valid
                    $model = new darren();
                    $user = $model->getWhere('user', ['username' => $name]); // Dapatkan pengguna berdasarkan username
    
                    if ($user && $user->password === $pw) { // Verifikasi password tanpa hash
                        // Set session
                        session()->put('username', $user->username);
                        session()->put('id_user', $user->id_user);
                        session()->put('id_level', $user->id_level);
    
                        // Catat aktivitas login (opsional)
                        // $activityLog = [
                        //     'id_user' => session()->get('id_user'),
                        //     'activity' => 'Login',
                        //     'time' => now()
                        // ];
                        // $model->logActivity($activityLog);
    
                        return redirect()->to('dashboard');
                    } else {
                        return redirect()->to('login')->with('error', 'Invalid username or password.');
                    }
                } else {
                    // CAPTCHA tidak valid
                    return redirect()->to('login')->with('error', 'Invalid CAPTCHA.');
                }
            } else {
                return redirect()->to('login')->with('error', 'CAPTCHA session is not set.');
            }
        }
    }
    
private function isInternetAvailable()
{
	$connected = @fsockopen("www.google.com", 80); 
	if ($connected){
		fclose($connected);
		return true;
	}
	return false;
}

public function generateCaptcha()
{
    $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

    // Store the CAPTCHA code in the session
    session()->put('captcha_code', $code); // Gunakan put() untuk menyimpan data di session

    // Generate the image
    $image = imagecreatetruecolor(120, 40);
    $bgColor = imagecolorallocate($image, 255, 255, 255);
    $textColor = imagecolorallocate($image, 0, 0, 0);

    imagefilledrectangle($image, 0, 0, 120, 40, $bgColor);
    imagestring($image, 5, 10, 10, $code, $textColor);

    // Set the content type header - in this case image/png
    // Kembalikan gambar sebagai response
    ob_start(); // Mulai buffer output
    imagepng($image);
    $imageData = ob_get_contents(); // Dapatkan isi buffer
    ob_end_clean(); // Bersihkan buffer

    // Free up memory
    imagedestroy($image);

    return response($imageData)
                ->header('Content-Type', 'image/png'); // Kembalikan gambar sebagai response
}

public function log()
{
    // Check user level from session
    $id_level = Session::get('id_level');

    // Redirect if the user is not logged in or not an admin
    if (!$id_level) {
        return redirect()->to('home/login');
    } elseif ($id_level != 1) {
        return redirect()->to('home/error404');
    }

    // Fetch settings data
    $model = new darren();
    $where = array('id_setting' => 1);
    $data['darren2'] = $model->getwhere('setting', $where);
    $data['logs'] = $model->getLogData();
    
    echo view('header',$data);
    echo view('menu',$data);
    echo view('log',$data);
    echo view('footer');
}

public function aksiAddAlumni(Request $request)
    {
      

        // Mengambil semua input data
        $data = [
            'nama_alumni' => $request->input('nama'),
            'jurusan' => $request->input('jurusan'),
            'NIS' => $request->input('nis'),
            'tahun_lulus' => $request->input('tahun'),
            'pekerjaan' => $request->input('pekerjaan'),
            'perusahaan' => $request->input('perusahaan'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
           
        ];

       
        $model = new Darren(); 
        $model->tambah('alumni', $data);

        // Redirect ke halaman tertentu setelah insert berhasil
        return redirect()->back()->with('success', 'Data alumni berhasil ditambahkan.');
    }

    public function setting()
    {
        $id_level = session()->get('id_level');	

        // Cek apakah pengguna sudah login
        if (!$id_level) {
            return redirect()->route('login'); // Redirect ke halaman login
        } elseif ($id_level != 1) {
            return redirect()->route('error404'); // Redirect ke halaman error
        } else {
            // Ambil data dari database
            $model = new darren();
            $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);

            // Log aktivitas pengguna
            $id_user = session()->get('id');
            $activityLog = [
                'id_user' => $id_user,
                'activity' => 'Masuk Menu Setting',
                'time' => now()->toDateTimeString()
            ];
            $model->logActivity($activityLog);

            echo view('header', $data);
            echo view('menu', $data);
            echo view('setting', $data);
            echo view('footer');
        }
    }

    public function editsetting(Request $request)
    {
        // Initialize the model
        $model = new darren();
        $namawebsite = $request->input('namaweb');
    
        $data = ['namawebsite' => $namawebsite];
    
        // Process upload for tab icon
        if ($request->hasFile('tab') && $request->file('tab')->isValid()) {
            $tab = $request->file('tab');
            $tabName = time() . '_' . $tab->getClientOriginalName(); // Save file with unique name
            $tab->move(public_path('img'), $tabName);
            $data['icontab'] = $tabName; // Save file name to database
        }
    
        // Process upload for menu icon
        if ($request->hasFile('menu') && $request->file('menu')->isValid()) {
            $menu = $request->file('menu');
            $menuName = time() . '_' . $menu->getClientOriginalName();
            $menu->move(public_path('img'), $menuName);
            $data['iconmenu'] = $menuName;
        }
    
        // Process upload for login icon
        if ($request->hasFile('login') && $request->file('login')->isValid()) {
            $login = $request->file('login');
            $loginName = time() . '_' . $login->getClientOriginalName();
            $login->move(public_path('img'), $loginName);
            $data['iconlogin'] = $loginName;
        }
    
        // Update data in database
        $where = ['id_setting' => 1];
        $model->edit('setting',$where, $data ); // Ensure your edit method handles this
    
        // Redirect to the settings page with success message
        return redirect()->route('setting')->with('success', 'Settings updated successfully!'); // Adjust as necessary
    }

    public function error404()
	{
			$model = new darren();
			$where = array('id_setting' => 1);
			$data['darren2'] = $model->getwhere('setting', $where);
			echo view('header', $data);
			echo view('error404', $data);
	}

    public function logout()
{
    $model = new darren(); // Use the appropriate model name with proper casing.
 
    $id_user = session()->get('id'); // Get the user ID from the session
    if ($id_user) {
        $activityLog = [
            'id_user' => $id_user,
            'activity' => 'Logout',
            'time' => now() // Using Carbon for the current time
        ];
        $model->logActivity($activityLog);
    }

    // Destroy the session
    session()->flush(); // This will remove all session data

    // Redirect to login
    return redirect()->route('login'); // Use route name for redirection
}


}
