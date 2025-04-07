<?php

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Lightit\Shared\App\Exceptions\InvalidActionException;

Route::get('invalid', static fn() => throw new InvalidActionException("Is not valid"));

Route::get('/cities', static fn () => view('cities.index'))->name('cities');
Route::get('/airlines', static fn () => view('airlines.index'))->name('airlines');
Route::get('/flights', static fn () => view('flights.index'))->name('flights');
Route::get('{unknown}', static fn () => view('404'))->where('unknown', '^(?!api).*$');

