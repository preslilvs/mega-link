<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?echo ("<pre>");?>
<?//print_r($arResult);?>
<?echo ("</pre>");?>
<?function orderBy($data, $field)
  {
    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
    usort($data, create_function('$a,$b', $code));
    return $data;
  }

  
  ?>
<?if ($arResult["ITEMS"])
{?>
<table  cellpadding="1" cellspacing="1" class="prodtable" >
	<tr style="background-color:#D7EBF4;">
		<td align="center">Код товара</td>
		<td align="center" width="392px">Наименование, краткое описание</td>
		<td>Фото</td>
		<td align="center">На складе</td>
		<td align="center">Транзит</td>
		<td align="center">Цена</td>
		<td></td>
	</tr>
	<?foreach($arResult["ITEMS"] as $cell=>$arElement)
	{?>
		
		<tr>
			<td align="center"><?=$arElement["PROPERTIES"]["PRODUCT_ID"]["VALUE"]?></td>
			<td><a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
					
					<?=$arElement["NAME"]?>
					</a>
					<!--<br />
					<?=$arElement["PREVIEW_TEXT"]?>
					-->
					<!--<br />
					<noindex>
						<a href="<?echo $arElement["BUY_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
							
					</noindex>
					-->
			</td>
			<td>
			<?if($arElement["PREVIEW_PICTURE"]){?>
					<img border="0" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" width="67" height="73" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" align="left" />
					<?}?>
			</td>
			<td align="right">
				<?=$arElement["CATALOG_QUANTITY"]?>
			</td>
			<td align="right">
				<?=$arElement["PROPERTIES"]["78"]["VALUE"]?>
				
					
			</td>
			<td align="right" style="padding:0 5px 0 5px;">
			<?		 
				$data = orderBy($arElement["PRICES"], 'VALUE');	
  			  ?>
			 
				<?foreach($data as $code=>$arPrice):?>
				
					<?if($arPrice["CAN_ACCESS"]):?>
					<nobr><span class="с4"><?=$arPrice["PRINT_VALUE"]?></span></nobr>
					<?break;?>
					<?endif;?>
				<?endforeach;?>
				
			</td>
			<td valign="bottom">
			<form action="<?=$APPLICATION->GetCurPageParam();?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="BUY">
				<input type="hidden" name="id" value="<?=$arElement["ID"]?>">
			<nobr><input type="text" name="quantity" value="1" size="3" style="vertical-align: bottom;" />&nbsp;<input type="submit" name="actionADD2BASKET" value="" class="basket_img"  /></nobr>
			</form>
			</td>
			
		</tr>
	<?}?>
</table>
<?}?>
<br /><?=$arResult["NAV_STRING"]?>
