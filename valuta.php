<?php   
include("classes/header_html.php");
include("classes/css_js_includes.php");
include("classes/body_html.php");
include("classes/headings.php");

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
	?>
	<table>
		<th>Valuta</th>
		<th>Kupovni</th>
		<th>Srednji</th>
		<th>Prodajni</th>
		<tr>
			<td>CHF</td>
			<td>5.642</td>
			<td>5.861</td>
			<td>6.061</td>
			
		</tr>
		<tr>
			<td>EUR</td>
			<td>7.156</td>
			<td>7.258</td>
			<td>7.356</td>
		</tr>
		<tr>
			
				<td>USD</td>
				<td>4.326</td>
				<td>4.586</td>
				<td>4.698</td>
				
			
		</tr>
	</table>
	
	</section>
	<div id="input">
<select id="selected" onChange="selected(this.value)">
    <option id=""></option>
	<option id="CHF">CHF</option>
	<option id="EUR">EUR</option>
	<option id="USD">USD</option>
</select>
<p id="txt"></p>
		
</div>
</div>
</body>
</html>
