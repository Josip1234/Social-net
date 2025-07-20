<?php   
include("classes/header_html.php");
include("classes/css_js_includes.php");
include("classes/body_html.php");
include("classes/headings.php");
include("templates/table_template.php");
include("templates/forms_templates.php");
include("classes/paragraph.php");

echo Header::START_HTML;
echo Header::HTML_LANG;
echo Header::OPEN_HEADER;
echo Header::META_CHARSET;
$title=new Title("Valute");
$title->printTitle();
echo Styles::CURRENCY_JS;
echo Styles::CURRENCY_CSS;
echo Header::CLOSE_HEADER;

echo Body::OPEN_BODY;
echo Body::OPEN_CONTAINER_WITH_ID_CN;
$heading=new Heading("Credit bank");
$heading->print_h2();
echo Body::OPEN_SECTION_WITH_ID_LISTE;
$th_data=array("Valuta","Kupovni","Srednji","Prodajni");
$td_data=array("CHF","5.642","5.861","6.061","EUR","7.156","7.258","7.356","USD","4.326","4.586","4.698");
$table=new Table("table table-striped",$th_data,$td_data,3);
$table->print_table();
echo Body::CLOSE_SECTION;
echo Body::OPEN_DIV_WITH_ID_INPUT;
echo Form::OPEN_SELECT_WITH_ONCHANGE_EVENT;
echo Form::OPEN_EMPTY_OPTION_WITH_ID;
echo Form::CLOSE_OPTION;
$currencies=array("CHF","EUR","USD");
$form=new Form("","",$currencies);
$form->print_option_values_only_with_id_s();
echo FORM::CLOSE_SELECT;
echo Paragraph::P_WITH_ID_TXT;
echo Paragraph::CLOSE_P;
	?>
		
</div>
</div>
</body>
</html>
