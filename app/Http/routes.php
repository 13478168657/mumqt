<?php

Route::get('/','Home\HomeController@home');
Route::get('login','Auth\AuthController@login');
Route::get('register','Auth\AuthController@register');
Route::post('post/register','Auth\AuthController@postRegister');
Route::get('article/list/{type}','Article\ArticleController@articleList');
Route::get('article/detail/{id}','Article\ArticleController@detail');
Route::get('article/create','Article\ArticleController@create');
Route::post('article/postCreate','Article\ArticleController@postCreate');
Route::post('webChat/check','WebChat\WebChatController@check');
Route::match(['get', 'post'],'WebChat/index','WebChat\WebChatController@index');
Route::get('weiXin/index','WebChat\WebXinController@index');
Route::get('menu/create','WebChat\WebChatController@create');