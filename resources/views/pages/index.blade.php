<?php

use function Livewire\Volt\state;
use App\Models\Url;
use Illuminate\Support\Str;
use function Livewire\Volt\{rules};

state(original_url: '', urls: fn() => Url::all());
rules(['original_url' => 'required|url:http,https']);

$addUrl = function () {
    $this->validate();

    Url::create([
        'original_url' => $this->original_url,
        'short_code' => Str::random(6), // Generate a random 6-character code for short URL
    ]);

    $this->original_url = '';
    $this->urls = Url::all();
};

?>
<div>
    @extends('layouts.master')

    @section('nav')
        @parent
    @stop

    @section('content')
        @volt
            <div>
                <section>
                    <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                        <div class="mr-auto place-self-center lg:col-span-7 sm:col-span-full">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{ $error }}</div>
                                @endforeach
                            @endif
                            <h1
                                class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                                URL Shortener</h1>
                            <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                                Shorten and Share Your Links Easily with our fast and reliable URL shortening service. Simplify
                                long URLs into short and memorable links for a seamless online experience.</p>
                            <a href="#"
                                class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                                Get started
                                <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                Shorten URL
                            </a>
                        </div>
                        <div class="lg:mt-0 lg:col-span-5 sm:col-span-full rounded-lg">
                            <div class="flex justify-end h-full items-center flex-col">
                                <div class="w-full h-full bg-contain bg-center"
                                    style="background-image: url('{{ Vite::asset('resources/images/banner.jpg') }}');">
                                    <div class="w-full h-full flex  justify-center items-center backdrop-brightness-50">
                                        <div class="mx-auto p-10">
                                            <h1 class="text-center text-3xl font-bold">Shorten Url </h1>
                                            <p class="text-center mt-1 text-sm leading-6 text-gray-600">Enter Long URL to be
                                                shortened.</p>
                                            <form wire:submit.prevent="addUrl" class="flex items-center">
                                                <label for="url" class="sr-only">Url</label>
                                                <div class="relative w-full">
                                                    <div
                                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                        {{-- <span class="w-5 h-5 text-gray-500 dark:text-gray-400"> www. </span> --}}
                                                    </div>
                                                    <input type="text" wire:model="original_url" placeholder="Enter URL"
                                                        id="url" autocomplete="url"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                </div>

                                                <button type="submit"
                                                    class="inline-flex items-center py-2.5 px-3 ml-2 text-sm font-medium bg-indigo-600 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Shorten</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="shortened-urls" class="mt-10">
                    <div class="mx-auto w-full flex justify-center  max-w-7xl py-6 sm:px-6 lg:px-8">
                        <div
                            class="text-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Shortened
                                URLs</h5>
                            @foreach ($urls as $url)
                                <p class="font-normal text-gray-700 dark:text-gray-400">
                                    {{ url($url->short_code) }}
                                </p>
                            @endforeach
                        </div>
                    </div>

                </section>
            </div>
        @endvolt
    @stop
</div>
