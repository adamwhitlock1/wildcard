<?php
require_once "vendor/autoload.php";
use App\Utils;
$count = Utils::readStats()->count;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Placeholder image service for wild animals.</title>
    <link rel="stylesheet" href="styles/tailwind.min.css">
    <style>
        .site-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100vh;
            background-image: url('/r/1500/1200');
            background-position: center center;
            background-size: cover;
            filter: opacity(10%);
        }
    </style>
</head>
<body>
<div class="site-container relative">
    <div class="relative container mx-auto p-4">
        <h1 class="text-4xl font-black font-mono text-blue-800 m-2"><span class="text-6xl">*</span> wildcard.fun</h1>
        <p class="font-light text-gray-700 mx-2">A simple image placeholder service for different critters.</p>
        <p class="mb-12 font-light text-gray-700 mx-2">Served <span class="font-black"><?=$count?></span> images and counting.</p>

        <h2 class="text-white text-2xl bg-blue-900 px-5 py-3 mt-4 border-b-4 border-blue-400 border-solid rounded-lg uppercase font-black tracking-widest">The endpoints</h2>

        <div class="block md:flex -mx-2">
            <div class="w-full md:w-1/2 px-2 mt-4">
                <div class="p-6 bg-gray-200 border-b-4 border-gray-400 text-white rounded-lg shadow-lg">
                    <code class="text-green-600 text-lg">https://wildcard.fun/r/{w}/{h}</code>
                    <p class="mt-3 text-gray-700 font-light">This endpoint gets a random critter image at a desired width {w} &amp; height {h}</p>
                    <p class="mt-1 text-gray-700 font-light">Example: <a href="https://wildcard.fun/r/400/600" target="_blank" class="underline text-green-600 font-bold">https://wildcard.fun/r/400/600</a></p>
                    <p class="mt-1 text-gray-700 font-light text-sm">Results in a random critter image at 400px wide by 600px high.</p>
                    <img class="rounded mt-4 shadow-lg" src="/r/200/200"/>
                </div>
            </div>

            <div class="w-full md:w-1/2 px-2 mt-4">
                <div class="p-6 bg-gray-200 border-b-4 border-gray-400 text-white rounded-lg shadow-lg">
                    <code class="text-green-600 text-lg">https://wildcard.fun/{animal}/{w}/{h}</code>
                    <p class="mt-3 text-gray-700 font-light">There are endpoints for each type of critter image.</p>
                    <p class="mt-1 text-gray-700 font-light">Example: <a href="https://wildcard.fun/cat/400/600" target="_blank" class="underline text-green-600 font-bold">https://wildcard.fun/cat/400/600</a></p>
                    <p class="mt-1 text-gray-700 font-light text-sm">Options: cat, dog, bird, bug, tiger, lion, fish</p>
                    <img class="rounded mt-4 shadow-lg" src="/cat/200/200"/>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
