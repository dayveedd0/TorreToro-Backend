<!DOCTYPE html>
<html lang="en" class="h-full bg-stone-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torre Tórò Architecture | Admin Portal Login</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/storage/uploads/branding/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fdf3f3',
                            100: '#fae4e4',
                            200: '#f6cdcd',
                            300: '#efa9a9',
                            400: '#e37777',
                            500: '#d24d4d',
                            600: '#be3434',
                            700: '#9f2828',
                            800: '#842424',
                            900: '#722121', // Torre Toro signature red
                            950: '#3e0c0c',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex items-center justify-center p-4 antialiased text-stone-200">

    <div class="max-w-md w-full">
        <!-- Logo and Branding Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center mb-4">
                <img src="/storage/uploads/branding/logo-white.png" alt="Torre Tórò" class="h-12 w-auto object-contain drop-shadow" onerror="this.onerror=null; this.src='/storage/uploads/branding/logo-symbol-white.png'">
            </div>
            <p class="text-xs text-stone-400 uppercase tracking-widest font-mono">Architecture & Workspace CMS Portal</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-stone-800/80 border border-stone-700 rounded-xl p-8 shadow-2xl backdrop-blur-sm">
            <h2 class="text-base font-semibold text-white mb-6 text-center tracking-wide">Sign In to Control Panel</h2>

            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-950/70 border border-red-800 text-red-300 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-stone-300 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@torretoro.com" required autofocus
                           class="w-full px-3.5 py-2.5 rounded-lg bg-stone-900 border border-stone-700 text-white placeholder-stone-500 text-sm focus:outline-none focus:ring-2 focus:ring-brand-800 focus:border-brand-800 transition">
                </div>

                <div>
                    <label class="block text-xs font-medium text-stone-300 mb-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required
                           class="w-full px-3.5 py-2.5 rounded-lg bg-stone-900 border border-stone-700 text-white placeholder-stone-500 text-sm focus:outline-none focus:ring-2 focus:ring-brand-800 focus:border-brand-800 transition">
                </div>

                <div class="flex items-center justify-between text-xs text-stone-400 pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-stone-900 border-stone-700 text-brand-900 focus:ring-brand-900">
                        <span>Remember session</span>
                    </label>
                </div>

                <button type="submit" class="w-full mt-4 py-2.5 px-4 bg-brand-800 hover:bg-brand-900 text-white font-medium rounded-lg shadow-md transition duration-150 text-sm tracking-wide">
                    Access Dashboard
                </button>
            </form>
        </div>

        <div class="text-center text-xs text-stone-400 mt-6">
            &copy; 2026 Torre Tórò Architecture & Interior Design. Multi-Domain CMS.
        </div>
    </div>

</body>
</html>
