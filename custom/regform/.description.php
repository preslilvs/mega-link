<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
	"NAME" => "�����",
	"DESCRIPTION" => "�����",
	"ICON" => "/images/user_register.gif",
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "myComponents",
		"SORT" => 2000,
		"NAME" => "��� ����������",
		"CHILD" => array(
			"ID" => "regform",
			"NAME" => "����� ����������� ��������",
			"SORT" => 10
		),
	),
);
