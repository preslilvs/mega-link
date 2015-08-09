<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//echo "<pre>"; //print_r($arParams); 
//print_r($arResult); echo "</pre>";

if (count($arResult["ERRORS"]) > 0)
{
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));
}
elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y")
{
	?><p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p><?
}?>

<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>

<table>
	<thead>
		<tr>
			<td colspan="2"><b><?=GetMessage("AUTH_REGISTER")?></b></td>
		</tr>
	</thead>
	<tbody>
<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
		<tr>
			<td><?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?></td>
			<td><?
	switch ($FIELD)
	{
		case "PASSWORD":
		case "CONFIRM_PASSWORD":
			?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" /><?
		break;

		case "PERSONAL_GENDER":
			?><select name="REGISTER[<?=$FIELD?>]">
				<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
				<option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
				<option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
			</select><?
		break;

		case "PERSONAL_COUNTRY":
		case "WORK_COUNTRY":
			?><select name="REGISTER[<?=$FIELD?>]"><?
			foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
			{
				?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
			<?
			}
			?></select><?
		break;

		case "PERSONAL_PHOTO":
		case "WORK_LOGO":
			?><input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" /><?
		break;

		case "PERSONAL_NOTES":
		case "WORK_NOTES":
			?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea><?
		break;
		default:
			if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
			?><input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" /><?
				if ($FIELD == "PERSONAL_BIRTHDAY")
					$APPLICATION->IncludeComponent(
						'bitrix:main.calendar',
						'',
						array(
							'SHOW_INPUT' => 'N',
							'FORM_NAME' => 'regform',
							'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
							'SHOW_TIME' => 'N'
						),
						null,
						array("HIDE_ICONS"=>"Y")
					);
				?><?
	}?></td>
		</tr>
<?endforeach?>
<tr>
		<td><?=GetMessage("USERTYPE")?></td>
		<td>
			<select name="USERTYPE" onchange="selectUserType(this.value);">
				<option value="private_person"><?=GetMessage("USERTYPE_PRIVATE")?></option>
				<option value="company"><?=GetMessage("USERTYPE_COMPANY")?></option>
			</select>
		</td>
</tr>

	<tr class="personRow">
		<td><?=GetMessage("name_private")?><span class="starrequired">*</span></td>
		<td><input name="name"  type="text" size="30" />	
		</td>
	</tr>
	<tr class="companyRow">
		<td><?=GetMessage("name_company")?><span class="starrequired">*</span></td>
		<td><input name="name"  type="text" size="30" />	
		</td>
	</tr>
	<tr class="companyRow">
		<td><?=GetMessage("director_name")?><span class="starrequired">*</span></td>
		<td><input name="director_name"  type="text" size="30" />	
		</td>
	</tr>
	<tr class="companyRow">
		<td><?=GetMessage("juridical_address")?><span class="starrequired">*</span></td>
		<td><input name="juridical_address"  type="text" size="30" />	
		</td>
	</tr>
	<tr>
		<td><?=GetMessage("postal_address")?></td>
		<td><input name="postal_address"  type="text" size="30" />	
		</td>
	</tr>
	<tr>
		<td><?=GetMessage("delivery_address")?><span class="starrequired">*</span></td>
		<td><input name="delivery_address"  type="text" size="30" />	
		</td>
	</tr>
	<tr>
		<td><?=GetMessage("phone")?></td>
		<td><input name="phone"  type="text" size="30" />	
		</td>
	</tr>
	<tr>
		<td><?=GetMessage("contact_person_name")?><span class="starrequired">*</span></td>
		<td><input name="contact_person_name"  type="text" size="30" />	
		</td>
	</tr>
	<!--<tr>
		<td><?=GetMessage("contact_person_mail")?><span class="starrequired">*</span></td>
		<td><input name="contact_person_mail"  type="text" size="30" />	
		</td>
	</tr>
	-->
	<tr>
		<td><?=GetMessage("contact_person_ICQ")?></td>
		<td><input name="contact_person_ICQ"  type="text" size="30" />	
		</td>
	</tr>
	<tr>
		<td><?=GetMessage("contact_person_phone")?><span class="starrequired">*</span></td>
		<td><input name="contact_person_phone"  type="text" size="30" />	
		</td>
	</tr>
	


<?// ********************* User properties ***************************************************?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
	<tr><td colspan="2"><?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></td></tr>
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
	<tr><td><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="required">*</span><?endif;?></td><td>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				$arUserField["USER_TYPE"]["USER_TYPE_ID"],
				array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
	<?endforeach;?>
<?endif;?>
<?// ******************** /User properties ***************************************************?>
<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
	?>
	
	
		<tr>
	
			<td ><b><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></b></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			</td>
		</tr>
		<tr>
			<td><?=GetMessage("REGISTER_CAPTCHA_PROMT")?> <span class="starrequired">*</span>:</td>
			<td><input type="text" name="captcha_word" maxlength="50" value="" /></td>
		</tr>
	
	<?
}
/* CAPTCHA */
?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td><input type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" /></td>
		</tr>
	</tfoot>
</table>
<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
<p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>

</form>

<script>
	function selectUserType(value)
	{
			var el = getElementsByClassName("companyRow");
			//var el2 = getElementsByClassName("personRow");
			for (var i=0; i<el.length; i++)
			{	
				if (value=="company")
				{
					el[i].style.display="table-row";
			//		el2[i].style.display="none";
				}
				else
				{

					el[i].style.display= "none";
				//	el2[i].style.display= "table-row";
				}
			}
			
			var el2 = getElementsByClassName("personRow");
			for (var i=0; i<el.length; i++)
			{	
				if (value=="private_person")
				{
					el2[i].style.display="table-row";
				}
				else
				{
					el2[i].style.display= "none";
				}
			}
	}
	
	function getElementsByClassName(classname, node)  
	{
		if(!node) node = document.getElementsByTagName("body")[0];
			var a = [];
			var re = new RegExp('\\b' + classname + '\\b');
			var els = node.getElementsByTagName("*");
			for(var i=0,j=els.length; i<j; i++)
				if(re.test(els[i].className))a.push(els[i]);
			return a;
	}
</script>