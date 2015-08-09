<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="menu-sitemap-tree">
<ul>
<?$previousLevel = 0;

$parentItems = array();
foreach($arResult["SECTIONS"] as $arSection)
{
	if ($arSection["IBLOCK_SECTION_ID"]!="")
	{
		$parentItems[] =  $arSection["IBLOCK_SECTION_ID"];
	}
}

$isOpen = Array();
$res = CIBlockSection::GetByID($_REQUEST["SECTION_ID"]);
if($arSection = $res->GetNext())
$res = CIBlockSection::GetByID($arSection["IBLOCK_SECTION_ID"]);
if($ar_res = $res->GetNext())
$isOpen[] = $ar_res['ID'];
for ($i==0; $i<$arSection["DEPTH_LEVEL"]; $i++)
{
	$res = CIBlockSection::GetByID($ar_res["IBLOCK_SECTION_ID"]);
	if($ar_res = $res->GetNext())
	$isOpen[] = $ar_res['ID'];
}
/*foreach($arResult["SECTIONS"] as $arSection)
{
	if($arSection["ID"]==$_REQUEST["SECTION_ID"])
	{
		$isOpen[] = $arSection["IBLOCK_SECTION_ID"];
		
		if ($arSection["DEPTH_LEVEL"]==3)
		{
			foreach($arResult["SECTIONS"] as $arSection_1)
			{
				if($arSection_1["ID"]==$arSection["IBLOCK_SECTION_ID"])
				{
					$isOpen[] = $arSection_1["IBLOCK_SECTION_ID"];
				}
			}
		}
	}
}*/





foreach($arResult["SECTIONS"] as $arSection):
//echo("<pre>");
//print_r($arSection);
///echo("</pre>");

	if ($previousLevel && $arSection["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arSection["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if (in_array($arSection["ID"],$parentItems) ){?>
			<li <?if (($_REQUEST["SECTION_ID"]!= $arSection["ID"])&(!in_array($arSection["ID"],$isOpen))):?>class="close"<?endif?> >
				<div  id ="<?=$arSection["ID"]?>" class="folder" onClick="OpenMenuNode(this)"></div>
				<div class="item-text">
				<a class="link1" onClick="OpenMenuNode(<?=$arSection["ID"]?>)" href="<?=$arSection["SECTION_PAGE_URL"]?>"><img src="/images/arrow.jpg" alt="" width="16" height="12" border="0"  /></a><a class="link1" href="<?=$arSection["SECTION_PAGE_URL"]?>" onClick="OpenMenuNode(<?=$arSection["ID"]?>)" ><?=$arSection["NAME"]?></a></div>
				<ul>

	<?}else{?>
	
				<li>
					<div class="page"></div>
					<?if($arSection["DEPTH_LEVEL"]==1){?>
						<div class="item-text"><a class="link1" onClick="OpenMenuNode(<?=$arSection["ID"]?>)" href="<?=$arSection["SECTION_PAGE_URL"]?>" <?if (($_GET["SECTION_ID"]==$arSection["ID"])|($SECTION_ID==$arSection["ID"])){?>style="font-weight:bold;"<?}?>><img src="/images/arrow.jpg" alt="" width="16" height="12" border="0"  /></a><a class="link1" href="<?=$arSection["SECTION_PAGE_URL"]?>" ><?=$arSection["NAME"]?></a></div>
					<?}
					else
					{?>
						<div class="item-text" <?if (($_GET["SECTION_ID"]==$arSection["ID"])|($SECTION_ID==$arSection["ID"])){?>style="font-weight:bold;"<?}?>><a class="link1" href="<?=$arSection["SECTION_PAGE_URL"]?>"  >- <?=$arSection["NAME"]?></a></div>
					<?}
					?>
				</li>
		

	<?}?>

	<?$previousLevel = $arSection["DEPTH_LEVEL"];?>
<?endforeach?>


<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>
</ul>
</div>
