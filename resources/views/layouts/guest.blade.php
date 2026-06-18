<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TechMart') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-slate-50 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-32 -left-24 h-80 w-80 rounded-full bg-red-100 blur-3xl"></div>
                <div class="absolute top-16 -right-20 h-72 w-72 rounded-full bg-blue-100 blur-3xl"></div>
            </div>

            <div class="relative min-h-screen flex flex-col lg:flex-row">
                <div class="hidden lg:flex flex-1 items-center justify-center p-10">
                    <div class="max-w-lg">
                        <a href="/" class="inline-flex items-center gap-3 text-red-600 font-bold text-2xl mb-8">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-lg bg-red-600 text-white shadow-lg">
                                TM
                            </span>
                            TechMart
                        </a>
                        <h1 class="text-4xl font-bold tracking-normal text-slate-950 mb-4">Mua sắm công nghệ gọn gàng hơn.</h1>
                        <p class="text-slate-600 text-lg leading-8">Đăng nhập để quản lý giỏ hàng, theo dõi đơn hàng và tiếp tục mua sắm các sản phẩm công nghệ bạn quan tâm.</p>
                    </div>
                </div>

                <div class="flex min-h-screen flex-1 items-center justify-center px-4 py-8 sm:px-6 lg:max-w-xl lg:bg-white/70 lg:backdrop-blur-xl lg:border-l lg:border-slate-200">
                    <div class="w-full max-w-md">
                        <div class="mb-6 text-center lg:hidden">
                            <a href="/" class="inline-flex items-center gap-3 text-red-600 font-bold text-2xl">
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-red-600 text-white shadow-lg">
                                    TM
                                </span>
                                TechMart
                            </a>
                        </div>

                        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 sm:p-8">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
