<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?echo("<pre>");?>
<?//print_r($arResult);?>
<?echo("</pre>");?>

<?function orderBy($data, $field)
  {
    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
    usort($data, create_function('$a,$b', $code));
    return $data;
  }
   ?>

<?if ($arResult["ITEMS"])
{?>
<span style="float:left;font-family:Tahoma, Geneva, sans-serif;color: #B20F00;font-size: 20px; font-weight: bold; padding-left: 13px;">Новинки товаров:</span>
	<table width="97%" border="0" cellspacing="0" cellpadding="0">
	
		
	<?
	$index = 0;
	$rowIndex=0;
	foreach($arResult["ITEMS"] as $cell=>$arElement)
	{?>
	
		<?if($index==0)
		{?>
			<tr>
		<?}?>
			<td class="bg1" width="30%" style="<?if ($rowIndex==0){?>border-top-width: 1px;border-top-style: solid;border-top-color: #DADADA;<?}?>">
				<table width="100%" border="0" cellpadding="4" cellspacing="4">
				  <tr><td>
					<?if ($arElement["PREVIEW_PICTURE"])
					{?>
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" width="67" height="73" border="0" /></a>
					<?}?>
					</td>
						<td align="left" valign="top" style="border-bottom-width:1px; border-bottom-color:#d7d7d7; border-bottom-style:solid;">
							<span class="с1"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="с1"><?=$arElement["NAME"]?></a></span><br />
							<span class="с2"><?=$arElement["PREVIEW_TEXT"];?></span>
						</td>
				  </tr>
				  <tr>
					<td align="center"></td>
					<td align="right"><nobr><span class="с4">
					<?		 
						$data = orderBy($arElement["PRICES"], 'VALUE');	
						foreach($data as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
							<?=$arPrice["PRINT_VALUE"]?>
							<?break;?>
							<?endif;?>
						<?endforeach;?>
					</span><span class="с5">руб.</span><span class="с4">&nbsp;<a href="<?=$arElement["BUY_URL"]?>"><img src="/images/get.jpg" width="53" height="18" /></a> </span></nobr></td>
				  </tr>
				</table>
			</td>
		<?if ($index==2)
		{?>
			</tr>
			<?$index=0;?>
			<?$rowIndex++;?>
		<?}
		else{
		
			$index++;
		}
		
	}?>           

<?if($index>0)
{?>
	</tr>
<?}?>
</table>
	
<?}?>
