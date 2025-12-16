<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }


    /**
     * Handle login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username is required.',
            'username.exists' => 'This username is not registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('username', 'password');
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Welcome back, Administrator ' . $user->name . '!');
            } elseif ($user->role === 'patroller') {
                return redirect()->intended('/patroller/dashboard')
                    ->with('success', 'Welcome back, Patroller ' . $user->name . '!');
            }
            
            return redirect()->intended('/')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()
            ->withErrors([
                'login' => 'Invalid login credentials. Please check your username and password or register if you don\'t have an account.',
            ])
            ->withInput($request->except('password'));
    }

    /**
     * Handle registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Professional validation rules with enhanced security
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-Z\s\-\.\']+$/',
                'not_regex:/<[^>]*>|&lt;|&gt;|&quot;|&apos;|&#x27;|&#39;/',
                'bail'
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:users,email',
                'not_regex:/<[^>]*>|&lt;|&gt;|&quot;|&apos;|&#x27;|&#39;/',
                'bail'
            ],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'unique:users,username',
                'alpha_num',
                'not_in:admin,administrator,root,user,guest,moderator,superadmin,sysadmin,test,demo,support,info,contact,help',
                'not_regex:/<[^>]*>|&lt;|&gt;|&quot;|&apos;|&#x27;|&#39;/',
                'bail'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&\-_])[A-Za-z\d@$!%*?&\-_]{8,}$/',
                'not_regex:/<[^>]*>|&lt;|&gt;|&quot;|&apos;|&#x27;|&#39;/',
                'bail'
            ],
        ], [
            // Name validation messages
            'name.required' => 'Please enter your full name.',
            'name.string' => 'Name must be text only.',
            'name.min' => 'Name must be at least 2 characters long.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'name.regex' => 'Name can only contain letters, spaces, hyphens, periods, and apostrophes.',
            'name.not_regex' => 'Name contains invalid characters. Please use only letters, spaces, hyphens, periods, and apostrophes.',
            
            // Email validation messages
            'email.required' => 'Please enter your email address.',
            'email.string' => 'Email must be text only.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'This email address is already registered. Try logging in instead.',
            'email.not_regex' => 'Email contains invalid characters. Please enter a valid email address.',
            
            // Username validation messages
            'username.required' => 'Please choose a username.',
            'username.string' => 'Username must be text only.',
            'username.min' => 'Username must be at least 3 characters long.',
            'username.max' => 'Username cannot exceed 30 characters.',
            'username.unique' => 'This username is already taken. Please choose another one.',
            'username.alpha_num' => 'Username can only contain letters and numbers.',
            'username.not_in' => 'This username is not available. Please choose a different one.',
            'username.not_regex' => 'Username contains invalid characters. Please use only letters and numbers.',
            
            // Password validation messages
            'password.required' => 'Please create a password.',
            'password.string' => 'Password must be text only.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password cannot exceed 64 characters.',
            'password.confirmed' => 'Password confirmation does not match. Please try again.',
            'password.regex' => 'Password must contain at least: one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&-_).',
            'password.not_regex' => 'Password contains invalid characters. Please use only letters, numbers, and special characters (@$!%*?&-_).',
            
            'password.regex' => 'Password must contain at least: one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&-_).',
            'password.not_regex' => 'Password contains invalid characters. Please use only letters, numbers, and special characters (@$!%*?&-_).',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Please correct the errors below and try again.');
        }

        try {
            // Additional security checks
            $email = strtolower(trim($request->email));
            $username = strtolower(trim($request->username));
            
            // Check for disposable email domains (basic check)
            $disposableDomains = [
                'tempmail.org', '10minutemail.com', 'guerrillamail.com', 'mailinator.com',
                'throwawaymail.com', 'yopmail.com', 'maildrop.cc', 'tempmail.net'
            ];
            
            $emailDomain = substr(strrchr($email, "@"), 1);
            if (in_array($emailDomain, $disposableDomains)) {
                return back()
                    ->withErrors(['email' => 'Disposable email addresses are not allowed. Please use a permanent email address.'])
                    ->withInput($request->except('password', 'password_confirmation'));
            }

            // Check for suspicious patterns in username
            $suspiciousPatterns = [
                '/admin/i', '/mod/i', '/sys/i', '/test/i', '/demo/i', '/support/i',
                '/info/i', '/contact/i', '/help/i', '/service/i', '/account/i'
            ];
            
            foreach ($suspiciousPatterns as $pattern) {
                if (preg_match($pattern, $username)) {
                    return back()
                        ->withErrors(['username' => 'This username is not available. Please choose a different one.'])
                        ->withInput($request->except('password', 'password_confirmation'));
                }
            }

            $user = User::create([
                'name' => trim($request->name),
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($request->password),
            ]);

            return redirect('/#login')
                ->with('registration_success', 'Account created successfully! Please login with your credentials.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors gracefully
            if ($e->getCode() == 23000) { // Duplicate entry
                return back()
                    ->withErrors(['email' => 'This email address or username is already registered.'])
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->with('error', 'Registration failed. Please try again.');
            }
            
            return back()
                ->withErrors(['general' => 'An error occurred during registration. Please try again.'])
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Registration failed. Please try again later.');
                
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Registration error: ' . $e->getMessage());
            
            return back()
                ->withErrors(['general' => 'An unexpected error occurred. Please try again.'])
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Registration failed. Please try again later.');
        }
    }

    /**
     * Handle logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'You have been logged out successfully.');
    }


    /**
     * Show user profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Check if user is admin and redirect to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Check if user is patroller and redirect to patroller dashboard
        if ($user->role === 'patroller') {
            return redirect()->route('patroller.dashboard');
        }
        
        $overallRank = $user->getOverallRank();
        $quizRank = $user->getGameRank('quiz');
        $wordScrambleRank = $user->getGameRank('word_scramble');
        
        return view('profile', compact('user', 'overallRank', 'quizRank', 'wordScrambleRank'));
    }

    /**
     * Update user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Check if this is a profile picture only upload
        $isProfilePictureOnly = $request->has('profile_picture_only');
        
        if ($isProfilePictureOnly) {
            // Simplified validation for profile picture only
            $validator = Validator::make($request->all(), [
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'profile_picture.required' => 'Please select an image to upload.',
                'profile_picture.image' => 'The file must be an image.',
                'profile_picture.mimes' => 'Only JPEG, PNG, JPG, and GIF images are allowed.',
                'profile_picture.max' => 'The image may not be larger than 2MB.',
            ]);
        } else {
            // Full profile validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'username' => 'required|string|unique:users,username,' . $user->id . '|max:255|alpha_num',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'Full name is required.',
                'name.regex' => 'Name can only contain letters and spaces.',
                'username.required' => 'Username is required.',
                'username.unique' => 'This username is already taken.',
                'username.alpha_num' => 'Username can only contain letters and numbers.',
                'profile_picture.image' => 'The file must be an image.',
                'profile_picture.mimes' => 'Only JPEG, PNG, JPG, and GIF images are allowed.',
                'profile_picture.max' => 'The image may not be larger than 2MB.',
            ]);
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            
            // Convert image to Base64 (Vercel/Serverless compatible storage)
            // This avoids issues with ephemeral filesystems or missing storage links
            try {
                $image_content = file_get_contents($file->getRealPath());
                $base64_image = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($image_content);
                $user->profile_picture = $base64_image;
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to process image: ' . $e->getMessage());
            }
        }

        // Update user data
        if (!$isProfilePictureOnly) {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'profile_picture' => $user->profile_picture,
            ]);
        } else {
            // Only update profile picture
            $user->update([
                'profile_picture' => $user->profile_picture,
            ]);
        }

        $successMessage = $isProfilePictureOnly ? 'Profile picture updated successfully!' : 'Profile updated successfully!';
        
        return back()
            ->with('success', $successMessage);
    }

    /**
     * Handle patrol map location visit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function visitLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|string',
            'location_name' => 'required|string',
        ], [
            'location_id.required' => 'Location ID is required.',
            'location_name.required' => 'Location name is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $locationId = $request->location_id;
        $locationName = $request->location_name;

        // Initialize visited locations data if not exists
        $visitedLocations = $user->visited_patrol_locations_data ?? [];
        
        // Check if location already visited
        if (in_array($locationId, $visitedLocations)) {
            return response()->json([
                'success' => false,
                'message' => 'You have already visited this location.',
                'already_visited' => true
            ]);
        }

        // Add location to visited array
        $visitedLocations[] = $locationId;
        
        // Update user data
        $user->visited_patrol_locations_data = $visitedLocations;
        $user->visited_patrol_locations = count($visitedLocations);
        $user->total_score += 10; // Award 10 points for visiting location
        $user->save();

        // Check for achievements
        $achievements = [];
        $totalVisited = count($visitedLocations);
        
        if ($totalVisited === 1) {
            $achievements[] = [
                'title' => 'First Visit',
                'description' => 'Visited your first patrol location!',
                'icon' => '🏆'
            ];
        }
        
        if ($totalVisited === 3) {
            $achievements[] = [
                'title' => 'Explorer',
                'description' => 'Visited 3 patrol locations!',
                'icon' => '🗺️'
            ];
        }
        
        if ($totalVisited === 6) {
            $achievements[] = [
                'title' => 'Conservation Hero',
                'description' => 'Visited all patrol locations!',
                'icon' => '🌟'
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Location visited successfully!',
            'points_awarded' => 10,
            'total_visited' => $totalVisited,
            'total_score' => $user->total_score,
            'achievements' => $achievements,
            'location_name' => $locationName
        ]);
    }
}
