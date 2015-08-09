<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
	"NAME" => "Формы",
	"DESCRIPTION" => "Формы",
	"ICON" => "/images/user_register.gif",
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "myComponents",
		"SORT" => 2000,
		"NAME" => "Мои компоненты",
		"CHILD" => array(
			"ID" => "regform",
			"NAME" => "Форма регистрации клиентов",
			"SORT" => 10
		),
	),
);
