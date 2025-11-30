## Firebase Setup Instructions

Your registration form requires Firebase for phone number verification (OTP). Follow these steps:

### 1. Create a Firebase Project

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Click "Add project" or select existing project
3. Enable **Phone Authentication**:
   - Navigate to **Authentication** → **Sign-in method**
   - Enable **Phone** provider

### 2. Get Firebase Configuration

1. In Firebase Console, go to **Project Settings** (gear icon)
2. Scroll down to "Your apps" section
3. Click on the **Web app** icon (</>) or create a new web app
4. Copy the Firebase configuration values

### 3. Update Your `.env` File

Add these values to your `.env` file (not `.env.example`):

```env
FIREBASE_API_KEY=your_actual_api_key_here
FIREBASE_AUTH_DOMAIN=your-project-id.firebaseapp.com
FIREBASE_PROJECT_ID=your-project-id
FIREBASE_STORAGE_BUCKET=your-project-id.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your_sender_id_here
FIREBASE_APP_ID=1:your_app_id_here
```

### 4. Configure Test Phone Numbers (Optional)

For testing without using real phone numbers:

1. In Firebase Console → **Authentication** → **Sign-in method**
2. Scroll to **Phone** section
3. Add test phone numbers (e.g., `+31612345678` with code `123456`)

### 5. Clear Cache

After updating `.env`:

```bash
php artisan config:clear
php artisan cache:clear
```

### 6. Verify Installation

Open the registration page in your browser and check:

- Console should NOT show Firebase errors
- reCAPTCHA should load
- Phone verification should work

---

## Testing Without Firebase

If you want to test registration without Firebase (bypass OTP), you have two options:

### Option A: Use Automated Tests

The PHPUnit tests in `tests/Feature/AuthenticationTest.php` already bypass Firebase:

```bash
php artisan test --filter=user_can_register_successfully
```

### Option B: Create a Test Route (Development Only)

Add this to `routes/web.php` (remove in production):

```php
// TEST ONLY - Remove in production
if (config('app.env') === 'local') {
    Route::post('/test-register-no-otp', function(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required|unique:users',
            'password' => 'required|min:6',
            'user_type' => 'required',
            'base_city' => 'required',
        ]);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'base_city' => $validated['base_city'],
        ]);

        Auth::login($user);
        return redirect('/user-dashboard');
    });
}
```

---

## Common Issues

### Error: "No Firebase App '[DEFAULT]' has been created"

**Solution:** Add Firebase configuration to your `.env` file (see step 3 above)

### Error: "Firebase: Error (auth/invalid-api-key)"

**Solution:** Verify your `FIREBASE_API_KEY` is correct

### Error: "reCAPTCHA validation failed"

**Solution:** Ensure you're testing on `localhost` or add your domain to Firebase's authorized domains

### OTP not received

**Solution:**

- Check Firebase Console → **Authentication** → **Usage** for any errors
- Verify your phone number format (e.g., `+31612345678`)
- Use test phone numbers in development

---

## Current Status

✅ Firebase initialization code added to `registration.blade.php`  
✅ Environment variables defined in `.env.example`  
⚠️ **Action Required:** Add actual Firebase values to your `.env` file

## What Changed

I've fixed the Firebase initialization error by adding proper config:

**File: `resources/views/auth/registration.blade.php`**

- Added Firebase initialization with environment variables
- Checks if Firebase is already initialized to prevent duplicates

**File: `.env.example`**

- Added all Firebase configuration variables
- Added documentation for required values

The automated tests in `tests/Feature/AuthenticationTest.php` continue to work because they bypass the browser/Firebase entirely and call the backend registration endpoint directly.
