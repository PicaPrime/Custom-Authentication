<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen">
  <main class="w-full max-w-md mx-auto">
    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 lg:p-8">
      <h1 class="text-xl font-medium mb-4 dark:text-[#EDEDEC]">Login</h1>

      @if ($errors->any())
      <div class="mb-4 text-sm text-[#f53003] dark:text-[#FF4433]">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label for="email" class="block text-sm mb-1 dark:text-[#EDEDEC]">Email</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}"  autocomplete="email" autofocus class="w-full border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm px-3 py-2 bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:border-[#19140035] dark:focus:border-[#3E3E3A]">
          @error('email')
          <div class="mt-1 text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</div>
          @enderror
        </div>

        // for phone
        <div>
          <label for="phone" class="block text-sm mb-1 dark:text-[#EDEDEC]">Phone</label>
          <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"  autocomplete="tel" class="w-full border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm px-3 py-2 bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:border-[#19140035] dark:focus:border-[#3E3E3A]">
          @error('phone')
          <div class="mt-1 text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</div>
          @enderror
        </div>

        <div>
          <label for="password" class="block text-sm mb-1 dark:text-[#EDEDEC]">Password</label>
          <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm px-3 py-2 bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:border-[#19140035] dark:focus:border-[#3E3E3A]">
          @error('password')
          <div class="mt-1 text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</div>
          @enderror
        </div>

        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 text-sm dark:text-[#EDEDEC]">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm">
            Remember me
          </label>
          <a href="#" class="text-sm underline underline-offset-4 text-[#f53003] dark:text-[#FF4433]">Forgot password?</a>
        </div>

        <div>
          <button type="submit" class="w-full inline-block px-5 py-2 bg-[#1b1b18] text-white rounded-sm border border-black hover:bg-black hover:border-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:border-[#eeeeec] dark:hover:bg-white dark:hover:border-white">Sign in</button>
        </div>
      </form>

      <p class="mt-4 text-sm dark:text-[#A1A09A]">Don't have an account?
        <a href="{{ url('/register') }}" class="font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433]">Create one</a>
      </p>
    </div>
  </main>
</body>
</html>


