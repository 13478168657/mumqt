<?php

Route::get('/','Home\HomeController@home');
Route::get('/login','Auth\AuthController@login');
Route::get('/register','Auth\AuthController@register');
Route::post('/post/register','Auth\AuthController@postRegister');
Route::get('/article/list/{type}','Article\ArticleController@articleList');
Route::get('/article/detail/{id}','Article\ArticleController@detail');
Route::get('/article/create','Article\ArticleController@create');
Route::post('/article/postCreate','Article\ArticleController@postCreate');
Route::get('/webChat/check','WebChat\WebChatController@check');