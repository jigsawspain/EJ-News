<?php

/*
*** EJigsaw News Admin Module
**
*** By Jigsaw Spain - www.jigsawspain.com
*/

if (!class_exists("EJ_news"))
{
class EJ_news
{
	public $version = "0.0.1";
	public $creator = "Jigsaw Spain";
	public $name = "EJigsaw News";
	private $EJ_mysql;
	private $vars;
	private $moduleloc;
	private $settings;
	
	function EJ_news ($EJ_mysql, $_vars, $_settings)
	{
		$this->EJ_mysql = $EJ_mysql;
		$this->vars = $_vars;
		$this->moduleloc = "modules/EJ_news/";
		$this->settings = $_settings;
	}
	
	function install()
	{
		echo "
			<p class=\"EJ_instText\">
			&gt; EJ News Install Procedure
			</p>";
		// Check for / create table
		echo "
			<p class=\"EJ_instText\">
			&gt; Checking and Creating Tables...
			</p>";
		$this->EJ_mysql->query("SHOW TABLES LIKE '{$this->EJ_mysql->prefix}module_EJ_news%'");
		if ($this->EJ_mysql->numRows() == 2)
		{
			echo "
			<p class=\"EJ_instText\">
				&gt;&gt; EJ_news tables already found!<br/>
				&gt;&gt; Checking default settings
			</p>";
		} else
		{
			// Main news Table
			$this->EJ_mysql->query("CREATE TABLE IF NOT EXISTS {$this->EJ_mysql->prefix}module_EJ_news (
				EJ_newsId INT(11) NOT NULL AUTO_INCREMENT ,
				EJ_newsDate DATE NOT NULL ,
				EJ_newsTitle VARCHAR(100) NOT NULL ,
				EJ_newsText TEXT NOT NULL ,
				EJ_newsImage VARCHAR(50) ,
				EJ_newsHidden TINYINT(1) NOT NULL DEFAULT 1 ,
				EJ_newsPoster VARCHAR(20) NOT NULL ,
				EJ_newsCat INT(6) NOT NULL ,
				EJ_newsTime VARCHAR(5) NOT NULL ,
				EJ_newsHits INT(6) NOT NULL ,
				PRIMARY KEY (EJ_newsId)
				)");
			$this->EJ_mysql->query("SHOW TABLES LIKE '{$this->EJ_mysql->prefix}module_EJ_news'");
			if ($this->EJ_mysql->numRows()!=1) return false;
			// news Settings Table
			$this->EJ_mysql->query("CREATE TABLE IF NOT EXISTS {$this->EJ_mysql->prefix}module_EJ_news_settings (
				setting VARCHAR(20) NOT NULL ,
				value VARCHAR(100) NOT NULL ,
				PRIMARY KEY (setting)
				)");
			$this->EJ_mysql->query("SHOW TABLES LIKE '{$this->EJ_mysql->prefix}module_EJ_news_settings'");
			if ($this->EJ_mysql->numRows()!=1) return false;
			// news Categories Table
			$this->EJ_mysql->query("CREATE TABLE IF NOT EXISTS {$this->EJ_mysql->prefix}module_EJ_news_cats (
				catId INT(6) NOT NULL AUTO_INCREMENT,
				subCatOf INT(6) ,
				catName VARCHAR(30) NOT NULL ,
				catDesc TEXT ,
				PRIMARY KEY (catId)
				)");
			$this->EJ_mysql->query("SHOW TABLES LIKE '{$this->EJ_mysql->prefix}module_EJ_news_cats'");
			if ($this->EJ_mysql->numRows()!=1) return false;
			// Create initial news
			$this->EJ_mysql->query("SELECT catId FROM {$this->EJ_mysql->prefix}module_EJ_news_cats");
			if ($this->EJ_mysql->numRows()==0)
			{
				echo "
				<p class=\"EJ_instText\">
				&gt; Creating initital news...
				</p>";
				$this->EJ_mysql->query("INSERT INTO {$this->EJ_mysql->prefix}module_EJ_news SET EJ_newsDate = DATE(NOW()), EJ_newsTitle = 'EJ News Installed Successfully!', EJ_newsText = 'This news article has been added by the EJ News setup procedure to demonstrate how your news will display on your site.<br /><br />Please edit or delete this news article when you are happy with your setup.<br /><br />EJ News - By Jigsaw Spain - <a href=\"http://www.jigsawspain.com\" target=\"_blank\">http://www.jigsawspain.com</a>', EJ_newsHidden = 0, EJ_newsPoster = 'admin', EJ_newsCat = 1, EJ_newsImage='noimage.png', EJ_newsLoc1 = 'No Address Provided', EJ_newsTime = '12:00'");
			}
			// Create initial categories
			$this->EJ_mysql->query("SELECT catId FROM {$this->EJ_mysql->prefix}module_EJ_news_cats");
			if ($this->EJ_mysql->numRows()==0)
			{
				echo "
				<p class=\"EJ_instText\">
				&gt; Creating initital news category...
				</p>";
				$this->EJ_mysql->query("INSERT INTO {$this->EJ_mysql->prefix}module_EJ_news_cats SET subCatOf = NULL, catname = 'General News', catDesc = 'This is the default category set up by EJ_news'");
			}
		}
		// Check for / set up user permissions
		echo "
				<p class=\"EJ_instText\">
				&gt; Checking user permissions...
				</p>";
		$this->EJ_mysql->query("SHOW COLUMNS FROM {$this->EJ_mysql->prefix}users LIKE 'perm_EJ_news'");
		if ($this->EJ_mysql->numRows()==0)
		{
			$this->EJ_mysql->query("ALTER TABLE {$this->EJ_mysql->prefix}users ADD perm_EJ_news TINYINT(1) NOT NULL DEFAULT 0");
		}
		$this->EJ_mysql->query("UPDATE {$this->EJ_mysql->prefix}users SET perm_EJ_news = 1 WHERE userid = 'admin'");
		// Check / create initial settings
		echo "
			<p class=\"EJ_instText\">
			&gt; Creating initital settings...
			</p>";
		$this->EJ_mysql->query("INSERT INTO {$this->EJ_mysql->prefix}module_EJ_news_settings (setting, value) VALUES
			('small_width', '250px') ,
			('small_height', '350px') ,
			('small_articles', '3') ,
			('small_word_count', '25') ,
			('small_show_images', '1') ,
			('large_word_count', '30')
			ON DUPLICATE KEY UPDATE setting = setting");
		// Update module registry
		echo "
			<p class=\"EJ_instText\">
			&gt; Updating Module Registry...
			</p>";
		$this->EJ_mysql->query("INSERT INTO {$this->EJ_mysql->prefix}modules (moduleid, version, name, creator) VALUES
			('".get_class()."', '{$this->version}', '{$this->name}', '{$this->creator}')
			ON DUPLICATE KEY UPDATE moduleid = moduleid");
		echo "
			<p class=\"EJ_instText\">
			&gt; Install Successful!
			</p>";
		return true;
	}
	
	function update()
	{
		echo "
			<p class=\"EJ_instText\">
			&gt; EJ News Update Procedure
			</p>";
		switch ($this->vars['oldversion'])
		{
			default :
			break;
		}
		echo "
			<p class=\"EJ_instText\">
			&gt; Updating Module Registry...
			</p>";
		$this->EJ_mysql->query("UPDATE {$this->EJ_mysql->prefix}modules SET version = '{$this->version}' WHERE moduleid = '".get_class($this)."'");
		echo "
			<p class=\"EJ_instText\">
			&gt; Update to Version {$this->version} Successful!
			</p>";
	}
	
	function uninstall()
	{
		echo "
			<p class=\"EJ_instText\">
			&gt; Checking and Removing Tables...
			</p>";
		$this->EJ_mysql->query("DROP TABLE IF EXISTS {$this->EJ_mysql->prefix}module_EJ_news");
		$this->EJ_mysql->query("DROP TABLE IF EXISTS {$this->EJ_mysql->prefix}module_EJ_news_settings");
		$this->EJ_mysql->query("DROP TABLE IF EXISTS {$this->EJ_mysql->prefix}module_EJ_news_cats");
		echo "
			<p class=\"EJ_instText\">
			&gt; Removing User Permissions...
			</p>";
		$this->EJ_mysql->query("SHOW COLUMNS FROM {$this->EJ_mysql->prefix}users LIKE 'perm_EJ_news'");
		if ($this->EJ_mysql->numRows()!=0)
		{
			$this->EJ_mysql->query("ALTER TABLE {$this->EJ_mysql->prefix}users DROP perm_EJ_news");
		}
		echo "
			<p class=\"EJ_instText\">
			&gt; Updating Module Registry...
			</p>";
		$this->EJ_mysql->query("DELETE FROM {$this->EJ_mysql->prefix}modules WHERE moduleid = '".get_class()."'");
		echo "
			<p class=\"EJ_instText\">
			&gt; Uninstall Successful...
			</p>";
		return true;
	}
	
	function admin_page()
	{
		$content = "";
		$content .= '<a class="button" style="background-image: url('.$this->moduleloc.'add_icon.png)" href="./?module=EJ_news&action=addnews">Add news</a><a class="button" style="background-image: url('.$this->moduleloc.'search_icon.png)" href="./?module=EJ_news&action=search">news Search</a><a class="button" style="background-image: url('.$this->moduleloc.'cats_icon.png)" href="./?module=EJ_news&action=cats">Categories</a>';
		echo $content;
	}
	
	function search()
	{
		$content = '<div style="text-align: center; margin-top: 3px;"><a href="?module=EJ_news&action=admin_page"><img src="'.$this->moduleloc.'back.png" alt="Back to News" title="Back to News" style="border:0;" /></a></div>';
		$content .= '<h2  class="EJN" class="EJN"><img src="'.$this->moduleloc.'search_icon_small.png" alt="News Filter" /> News Filter</h2>';
		$results = array();
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM {$this->EJ_mysql->prefix}module_EJ_news WHERE 1=1";
		$newsdate = time();
		$newstext = "";
		$newscat = "";
		$newsposter = "";
		$anycheck = ' checked="checked"';
		if (!empty($this->vars['search']))
		{
			$s1 = explode(":::",$this->vars['search']);
			foreach ($s1 as $s2)
			{
				$s2 = explode("::", $s2);
				$search[$s2[0]] = $s2[1];
			}
			foreach ($search as $key => $value)
			{
				$skip = 0;
				switch ($key)
				{
					case 'EJ_newsDate' :
						$anycheck = "";
						$newsdate = strtotime($value);
					break;
					case 'EJ_newsText' :
						$skip=1;
						$query .= " AND (EJ_newsText LIKE '%$value%' OR EJ_newsTitle LIKE '%$value%')";
						$newstext = " value=\"$value\"";
					break;
					case 'EJ_newsCat' :
						$newscat = $value;
					break;
					case 'EJ_newsPoster' :
						$newsposter = $value;
					break;
				}
				if (!is_numeric($value)) $value = "'".$value."'";
				if ($skip==0) $query .= " AND $key = $value";
			}
		}
		if (isset($this->vars['items']))
		{
			$query .= " LIMIT ".$this->vars['items'];
		} else
		{
			$query .= " LIMIT 10";
		}
		$this->EJ_mysql->query("SELECT * FROM {$this->EJ_mysql->prefix}module_EJ_news_cats ORDER BY catName");
		$categories = "";
		while ($cat = $this->EJ_mysql->getRow())
		{
			$selected = "";
			if ($newscat == $cat['catId']) $selected = ' selected="selected"';
			$categories .= "<option value=\"{$cat['catId']}\"$selected>{$cat['catName']}</option>\n						";
		}
		$this->EJ_mysql->query("SELECT EJ_newsPoster FROM {$this->EJ_mysql->prefix}module_EJ_news GROUP BY EJ_newsPoster ORDER BY EJ_newsPoster");
		$posters = "";
		while ($post = $this->EJ_mysql->getRow())
		{
			$selected = "";
			if ($newsposter == $post['EJ_newsPoster']) $selected = ' selected="selected"';
			$posters .= "<option value=\"{$post['EJ_newsPoster']}\"$selected>{$post['EJ_newsPoster']}</option>\n						";
		}
		ob_start();
		$this->EJ_mysql->query($query);
		$content .= ob_get_contents();
		ob_end_clean();
		$content .= '
			<script src="'.$this->moduleloc.'EJ_news.js" language="javascript" type="text/javascript"></script>
			<script src="'.$this->moduleloc.'calendar.js" language="javascript" type="text/javascript"></script>
			<form name="search_form" id="search_form" method="post" action="./?module=EJ_news&action=search&search=go">
				<div style="float:left;">
					<strong>Date</strong>: Any Date <input type="checkbox" name="anydate" id="anydate" value="true"'.$anycheck.' onchange="updateFilter(\''.$_SESSION['key'].'\')"/> <strong>OR</strong><script>DateInput(\'date\', true, \'DD-MON-YYYY\', \''.date("d-M-Y", $newsdate).'\' , \''.$_SESSION['key'].'\');</script>
				</div>
				<div style="float:left; margin-right: 10px;">
					<strong>Title/Text Search</strong>:<br/>
					<input type="text" name="search_text" id="search_text" onkeyup="updateFilter(\''.$_SESSION['key'].'\')"'.$newstext.' />
				</div>
				<div style="float:left; margin-right: 10px;">
					<strong>Category</strong>:<br/>
					<select name="category" id="category" onchange="updateFilter(\''.$_SESSION['key'].'\')" />
						<option value="0">Any Category</option>
						'.$categories.'
					</select>
				</div>
				<div style="float:left; margin-right: 10px;">
					<strong>Posted By</strong>:<br/>
					<select name="poster" id="poster" onchange="updateFilter(\''.$_SESSION['key'].'\')" >
					<option value="0">Any Poster</option>
					'.$posters.'
					</select>
				</div>
				<div style="float:right;">
					<strong>Include Hidden</strong>:	<input type="checkbox" name="hidden" id="hidden" onchange="updateFilter(\''.$_SESSION['key'].'\')" checked="checked" /><br/>
					Show
					<select name="limit" id="limit"onchange="updateFilter(\''.$_SESSION['key'].'\')">
						<option value="10" selected="selected">10</option>
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					Results
				</div>
				<div style="clear:both;"></div>
			</form>
			';
		$result_count = $this->EJ_mysql->numRows();
		$content .= '<h2 class="EJN"><div style="float:right; margin-right: 5px;">Results Found: <span id="result_count">';
		$content2 = '</span></div><img src="'.$this->moduleloc.'search_icon_small.png" alt="Search Results" /> Search Results (click result to show/hide details)</h2>
			<div id="news_message"></div>
			<div id="search_results">';
		while ($news = $this->EJ_mysql->getRow())
		{
			$date = date("d/m/Y", strtotime($news['EJ_newsDate']));
			if (empty($news['EJ_newsImage']) or !file_exists($this->moduleloc."images/".$news['EJ_newsImage']))
			{
				$img = "noimage.png";
			} else
			{
				$img = $news['EJ_newsImage'];
			}
			$content2 .= "
				<div class=\"news_result\" id=\"{$news['EJ_newsId']}\">
					<div style=\"float: right;\"><img src=\"".$this->moduleloc."recycle.png\" alt=\"delete\" title=\"Delete news\" style=\"cursor: pointer; border: 0;\" onclick=\"deleteNews('{$news['EJ_newsId']}', '{$_SESSION['key']}')\" /> <a href=\"?module=EJ_news&action=editnews&newsid={$news['EJ_newsId']}\"><img src=\"".$this->moduleloc."edit.png\" alt=\"edit\" title=\"Edit news\" style=\"cursor: pointer; border: 0;\" /></a> <img src=\"".$this->moduleloc."blue_down.png\" alt=\"show/hide details\" title=\"Show/Hide Details\"style=\"cursor: pointer;\" onclick=\"Slide(this.parentNode.parentNode, 16, 150)\" /></div>
					<p><strong>$date - {$news['EJ_newsTitle']}</strong> posted by: {$news['EJ_newsPoster']}</p>
					<p><img src=\"{$this->moduleloc}images/$img\" alt=\"{$news['EJ_newsTitle']}\" class=\"newsImage\" />{$news['EJ_newsText']}</p>
				</div>";
		}
		$content2 .= '
			</div>
';
		$this->EJ_mysql->query("SELECT FOUND_ROWS() as results");
		$result_count = $this->EJ_mysql->getRow();
		echo $content.$result_count['results'].$content2;
	}
	
	function addnews()
	{
		$content = '<div style="text-align: center; margin-top: 3px;"><a href="?module=EJ_news&action=admin_page"><img src="'.$this->moduleloc.'back.png" alt="Back to news" title="Back to news" style="border:0;" /></a></div>
				<h2  class="EJN"><img src="'.$this->moduleloc.'add_icon_small.png" alt="Add news" /> Add news</h2>';
		$content .= '
				<script src="'.$this->moduleloc.'EJ_news.js" language="javascript" type="text/javascript"></script>
				<script src="'.$this->moduleloc.'addcalendar.js" language="javascript" type="text/javascript"></script>
				<div id="addnews">
					<form name="add_form" id="add_form" action="?module=EJ_news&action=addnews" method="post">
						<div id="addLeft">
							Click Image To Change<br/>
							<img id="newsimage" src="'.$this->moduleloc.'images/noimage.png" alt="Add An Image" title="Click to Add an Image" onclick="changepic()" style="width:200px; height:200px;" /><br/>
							<input type="hidden" name="image" id="image" />
							<input type="button" name="save" id="save" value="Save Changes" onclick="saveNews(\''.$_SESSION['key'].'\')"/><br/>
							<input type="button" name="cancel" id="cancel" value="Cancel Changes" onclick="document.location=\'?module=EJ_news&action=admin_page\'"/>
						</div>
						<div id="addRight">
							<strong>news Title:</strong><br/><input type="text" name="title" id="title" maxlength="100" size="40" /><br/>
							<strong>news Description:</strong><br/>
							<textarea name="desc" id="desc" rows="5" cols="40" /></textarea><br/>
							<strong>Category:</strong><br/>
							<select name="cat" id="cat">
								<option value="NONE" selected="selected">Please Select...</option>';
		$this->EJ_mysql->query("SELECT catId, subCatOf, catName, (SELECT catName FROM {$this->EJ_mysql->prefix}module_EJ_news_cats cats2 WHERE cats2.catId = cats1.subCatOf) AS parent FROM {$this->EJ_mysql->prefix}module_EJ_news_cats cats1 ORDER BY parent ASC, catName ASC");
		while ($cat = $this->EJ_mysql->getRow())
		{
			if (!empty($cat['parent']))
			{
			$content .= '
								<option value="'.$cat['catId'].'">'.$cat['parent'].'&gt;'.$cat['catName'].' ('.$cat['subCatOf'].'&gt;'.$cat['catId'].')</option>';
			} else
			{
				$content .= '
								<option value="'.$cat['catId'].'">'.$cat['catName'].' ('.$cat['catId'].')</option>';
			}
		}
		$content .= '
							</select><br/>
							<strong>news Date:</strong><br/>
							<script>DateInput(\'date\', true, \'DD-MON-YYYY\', \''.date("d-M-Y").'\' , \''.$_SESSION['key'].'\');</script>
							<strong>news Time: (hh:mm)</strong><br/>
							<input type="text" name="time" id="time" maxlength="5" size="5" value="00:00" /><br/>
							<strong>Posted By:</strong><br/>
							<select name="poster" id="poster">
								<option value="NONE" selected="selected">Please Select...</option>';
		if ($_SESSION['usertype']==9)
		{
			$usertype = 10;
		} else
		{
			$usertype = $_SESSION['usertype'];
		}
		$this->EJ_mysql->query("SELECT userid FROM {$this->EJ_mysql->prefix}users WHERE type < ".$usertype."");
		while ($user = $this->EJ_mysql->getRow())
		{
			if ($user['userid']==$_SESSION['userid'])
			{
				$selected = " selected=\"selected\"";
			} else
			{
				$selected = "";
			}
			$content .= '
								<option value="'.$user['userid'].'"'.$selected.'>'.$user['userid'].'</option>';
		}
		$content .= '
							</select><br/>
							<strong>Visibility:</strong><br/>
							<select name="hidden" id="hidden">
								<option value="1" selected="selected">Hidden</option>
								<option value="0">Visible</option>
							</select>
							<div id="news_message"></div>
						</div>
						<div style="clear: left;"></div>
					</form>
				</div>';
		echo $content;
	}
	
	function editnews()
	{
		$content = '<div style="text-align: center; margin-top: 3px;"><a href="?module=EJ_news&action=admin_page"><img src="'.$this->moduleloc.'back.png" alt="Back to news" title="Back to news" style="border:0;" /></a></div>
				<h2  class="EJN"><img src="'.$this->moduleloc.'edit.png" alt="Edit news" /> Edit news</h2>';
		$this->EJ_mysql->query("SELECT * FROM ".$this->EJ_mysql->prefix."module_EJ_news WHERE EJ_newsId = ".$this->vars['newsid']);
		if ($this->EJ_mysql->numRows()!=1)
		{
			$content .= '
				<div class="EJ_user_error"><strong>ERROR</strong>: news Id Not Found!<br/>Please try again.</div>';
		} else
		{
			$news = $this->EJ_mysql->getRow();
			if (empty($news['EJ_newsImage']) or !file_exists($this->moduleloc."images/".$news['EJ_newsImage'])) 
				$img = "noimage.png"; 
			else 
				$img = $news['EJ_newsImage'];
			$content .= '
				<script src="'.$this->moduleloc.'EJ_news.js" language="javascript" type="text/javascript"></script>
				<script src="'.$this->moduleloc.'addcalendar.js" language="javascript" type="text/javascript"></script>
				<div id="addnews">
					<form name="add_form" id="add_form" action="?module=EJ_news&action=editnews" method="post">
						<div id="addLeft">
							Click Image To Change<br/>
							<img id="newsimage" src="'.$this->moduleloc.'images/'.$img.'" alt="Change Image" title="Click to Change Image" onclick="changepic()" style="width:200px; height:200px;" /><br/>
							<input type="hidden" name="image" id="image" value="'.$img.'" />
							<input type="button" name="save" id="save" value="Save Changes" onclick="saveNews(\''.$_SESSION['key'].'\','.$this->vars['newsid'].')"/><br/>
							<input type="button" name="cancel" id="cancel" value="Cancel Changes" onclick="document.location=\'?module=EJ_news&action=admin_page\'"/>
						</div>
						<div id="addRight">
							<strong>news Title:</strong><br/><input type="text" name="title" id="title" maxlength="100" size="40" value="'.$news['EJ_newsTitle'].'" /><br/>
							<strong>news Description:</strong><br/>
							<textarea name="desc" id="desc" rows="5" cols="40" />'.str_replace(array("<br/>","<br />"), "\n", $news['EJ_newsText']).'</textarea><br/>
							<strong>Category:</strong><br/>
							<select name="cat" id="cat">
								<option value="NONE" selected="selected">Please Select...</option>';
			$this->EJ_mysql->query("SELECT catId, subCatOf, catName, (SELECT catName FROM {$this->EJ_mysql->prefix}module_EJ_news_cats cats2 WHERE cats2.catId = cats1.subCatOf) AS parent FROM {$this->EJ_mysql->prefix}module_EJ_news_cats cats1 ORDER BY parent ASC, catName ASC");
			while ($cat = $this->EJ_mysql->getRow())
			{
				if ($news['EJ_newsCat']==$cat['catId'])
				{
					$selected = " selected=\"selected\"";
				} else
				{
					$selected = "";
				}
				if (!empty($cat['parent']))
				{
				$content .= '
								<option value="'.$cat['catId'].'"'.$selected.'>'.$cat['parent'].'&gt;'.$cat['catName'].' ('.$cat['subCatOf'].'&gt;'.$cat['catId'].')</option>';
				} else
				{
					$content .= '
								<option value="'.$cat['catId'].'"'.$selected.'>'.$cat['catName'].' ('.$cat['catId'].')</option>';
				}
			}
			$content .= '
							</select><br/>
							<strong>news Date:</strong><br/>
							<script>DateInput(\'date\', true, \'DD-MON-YYYY\', \''.date("d-M-Y", strtotime($news['EJ_newsDate'])).'\' , \''.$_SESSION['key'].'\');</script>
							<strong>news Time: (hh:mm)</strong><br/>
							<input type="text" name="time" id="time" maxlength="5" size="5" value="'.$news['EJ_newsTime'].'" /><br/>
							<strong>Posted By:</strong><br/>
							<select name="poster" id="poster">
								<option value="NONE" selected="selected">Please Select...</option>';
			if ($_SESSION['usertype']==9)
			{
				$usertype = 10;
			} else
			{
				$usertype = $_SESSION['usertype'];
			}
			$this->EJ_mysql->query("SELECT userid FROM {$this->EJ_mysql->prefix}users WHERE type < ".$usertype."");
			while ($user = $this->EJ_mysql->getRow())
			{
				if ($user['userid']==$news['EJ_newsPoster'])
				{
					$selected = " selected=\"selected\"";
				} else
				{
					$selected = "";
				}
				$content .= '
								<option value="'.$user['userid'].'"'.$selected.'>'.$user['userid'].'</option>';
			}
			if ($news['EJ_newsHidden']==0)
			{
				$selectedvisible = " selected=\"selected\"";
				$selectedhidden = "";
			} else
			{
				$selectedvisible = "";
				$selectedhidden = " selected=\"selected\"";
			}
			$content .= '
							</select><br/>
							<strong>Visibility:</strong><br/>
							<select name="hidden" id="hidden">
								<option value="1"'.$selectedhidden.'>Hidden</option>
								<option value="0"'.$selectedvisible.'>Visible</option>
							</select>
							<div id="news_message"></div>
						</div>
						<div style="clear: left;"></div>
					</form>';
		}
		$content .= '
				</div>';
		echo $content;
	}
	
	function cats()
	{
		$content = '<div style="text-align: center; margin-top: 3px;"><a href="?module=EJ_news&action=admin_page"><img src="'.$this->moduleloc.'back.png" alt="Back to news" title="Back to news" style="border:0;" /></a></div>
				<h2  class="EJN"><img src="'.$this->moduleloc.'cats_icon_small.png" alt="Categories" /> Categories</h2>
				<script src="'.$this->moduleloc.'EJ_news.js" language="javascript" type="text/javascript"></script>';
		$this->EJ_mysql->query("SELECT *,(SELECT COUNT(*) FROM {$this->EJ_mysql->prefix}module_EJ_news WHERE EJ_newsCat = catId) AS news FROM {$this->EJ_mysql->prefix}module_EJ_news_cats ORDER BY subCatOf ASC, catName ASC");
		while ($cat = $this->EJ_mysql->getRow())
		{
			$cats[$cat['catId']] = $cat;
		}
		foreach ($cats as $cat)
		{
			$count = 0;
			$content .= '<div id="news_message"></div>';
			if (empty($cat['subCatOf']))
			{
				$content .= "<div class=\"cat_result\" id=\"{$cat['catId']}\">";
				foreach ($cats as $subcat)
				{
					if ($subcat['subCatOf'] == $cat['catId'])
					{
						$count += $subcat['news'];
						$subcats[$subcat['catId']] = $subcat;
					}
				}
				$content .= "<div style=\"float: right;\">";
				if (count($subcats)==0)
				{
					$content .= "<img src=\"".$this->moduleloc."recycle.png\" alt=\"delete\" title=\"Delete Category\" style=\"cursor: pointer; border: 0;\" onclick=\"deleteCat('{$cat['catId']}','{$_SESSION['key']}')\" /> ";
				}
				$content .= "<a href=\"?module=EJ_news&action=editcat&catid={$cat['catId']}\"><img src=\"".$this->moduleloc."edit.png\" alt=\"edit\" title=\"Edit Category\" style=\"cursor: pointer; border: 0;\" /></a>";
				if (count($subcats)!=0)
				{
					$content .= " <img src=\"".$this->moduleloc."blue_down.png\" alt=\"show/hide details\" title=\"Show/Hide Details\"style=\"cursor: pointer;\" onclick=\"Slide(this.parentNode.parentNode, 16, ".((count($subcats)+2)*17).")\" />";
				}
				$content .= "</div>";
				if (count($subcats)==0)
				{
					$content .= "<img class=\"news_cat_img\"src=\"{$this->moduleloc}cat_no_sub.png\" alt=\"\" />";
				} else
				{
					$content .= "<img class=\"news_cat_img\" src=\"{$this->moduleloc}cat_with_sub.png\" alt=\"\" style=\"cursor: pointer;\" onclick=\"Slide(this.parentNode, 16, ".((count($subcats)+2)*16).")\" />";
				}
				$content .= " {$cat['catName']} ({$cat['news']}";
				if ($count != 0)
				{
					$content .= " + $count in Sub-Categories";
				}
				$content .= ")";
				if ($cat['news']!=0) $content .= " <a href=\"?module=EJ_news&action=search&search=EJ_newsCat::{$cat['catId']}\"><img src=\"".$this->moduleloc."search_icon_small.png\" alt=\"Find\" title=\"Show news in this category\" /></a>";
				$i = 1;
				if (count($subcats) != 0)
				{
					foreach($subcats as $subcat)
					{
						if ($i == count($subcats))
						{
							$content .= "<br/><img class=\"news_cat_img\" src=\"{$this->moduleloc}sub_last.png\" alt=\"\" />";
						} else
						{
							$content .= "<br/><img class=\"news_cat_img\" src=\"{$this->moduleloc}sub_middle.png\" alt=\"\" />";
						}
						$content .= " {$subcat['catName']} ({$subcat['news']})";
						if ($subcat['news']!=0) $content .= " <a href=\"?module=EJ_news&action=search&search=EJ_newsCat::{$subcat['catId']}\"><img src=\"".$this->moduleloc."search_icon_small.png\" alt=\"Find\" title=\"Show news in this category\" /></a>";
						$content .= " <a href=\"?module=EJ_news&action=editcat&catid={$subcat['catId']}\"><img src=\"".$this->moduleloc."edit.png\" alt=\"edit\" title=\"Edit Category\" style=\"cursor: pointer; border: 0;\" /></a>";
						if ($subcat['news']==0)
						{
							$content .= "<img src=\"".$this->moduleloc."recycle.png\" alt=\"delete\" title=\"Delete Category\" style=\"cursor: pointer; border: 0;\" onclick=\"deleteCat('{$subcat['catId']}','{$_SESSION['key']}')\" />";
						}
						$i++;
					}
				}
				$content .= "</div>";
				unset($subcats);
			}
		}
		$content .= "
		<div>
			<h2  class=\"EJN\"><img src=\"{$this->moduleloc}cats_icon_small.png\" alt=\"Categories\" /> Add New Category</h2>
			<form name=\"new_cat_form\" id=\"new_cat_form\" method=\"post\" action=\"#\" style=\"margin: 10px;\">
				<div style=\"float:left; margin-right: 5px;\">
					<strong>Category Name:</strong><br/>
					<input type=\"text\" name=\"new_name\" id=\"new_name\" maxlength=\"30\" />
				</div>
				<div style=\"float:left; margin-right: 5px;\">
					<strong>Sub-Category Of:</strong><br/>
					<select name=\"new_sub\" id=\"new_sub\">
						<option value=\"NONE\">None - Main Category</option>
						";
			foreach ($cats as $cat)
			{
				if (empty($cat['subCatOf'])) $content .= "<option value=\"{$cat['catId']}\">{$cat['catName']}</option>";
			}
			$content .= "
					</select>
				</div>
				<div style=\"float:left; margin-right: 5px;\">
					<strong>Description: (optional)</strong><br/>
					<textarea name=\"new_desc\" id=\"new_desc\" rows=\"3\" cols=\"40\" /></textarea>
				</div>
				<div style=\"float:left; margin-right: 5px;\">
					<input type=\"hidden\" name=\"catid\" id=\"catid\" value=\"\"/><input type=\"button\" name=\"save\" id=\"save\" value=\"Add Category\" onclick=\"addCat('{$_SESSION['key']}')\" style=\"margin-top: 15px; height: 52px; width: 150px;\" />
				</div>
				<div style=\"clear:left;\" id=\"new_cat_message\"></div>
			</form>
		</div>";
		echo $content;
	}
	
	function editcat()
	{
		$content = '<div style="text-align: center; margin-top: 3px;"><a href="?module=EJ_news&action=admin_page"><img src="'.$this->moduleloc.'back.png" alt="Back to news" title="Back to news" style="border:0;" /></a></div>
				<h2  class="EJN"><img src="'.$this->moduleloc.'edit.png" alt="Edit Category" /> Edit Category</h2>';
		$this->EJ_mysql->query("SELECT * FROM ".$this->EJ_mysql->prefix."module_EJ_news_cats WHERE catId = ".$this->vars['catid']);
		if ($this->EJ_mysql->numRows()!=1)
		{
			$content .= '
				<div class="EJ_user_error"><strong>ERROR</strong>: Category Id Not Found!<br/>Please try again.</div>';
		} else
		{
			$cat = $this->EJ_mysql->getRow();
			$selected = "";
			if (empty($cat['subCatOf'])) $selected = ' selected="selected"';
			$content .= "
				<script src=\"{$this->moduleloc}EJ_news.js\" language=\"javascript\" type=\"text/javascript\"></script>
				<div>
					<form name=\"new_cat_form\" id=\"new_cat_form\" method=\"post\" action=\"#\" style=\"margin: 10px;\">
						<div style=\"float:left; margin-right: 5px;\">
							<strong>Category Name:</strong><br/>
							<input type=\"text\" name=\"new_name\" id=\"new_name\" maxlength=\"30\" value=\"{$cat['catName']}\" />
						</div>
						<div style=\"float:left; margin-right: 5px;\">
							<strong>Sub-Category Of:</strong><br/>
							<select name=\"new_sub\" id=\"new_sub\">
								<option value=\"NONE\"$selected>None - Main Category</option>
								";
					$this->EJ_mysql->query("SELECT * FROM ".$this->EJ_mysql->prefix."module_EJ_news_cats WHERE (ISNULL(subCatOf) OR subCatOf = '') AND catId != ".$cat['catId']);
					while ($cat1 = $this->EJ_mysql->getRow())
					{
						$cats[$cat1['catId']] = $cat1;
					}
					foreach ($cats as $cat1)
					{
						$selected = "";
						if ($cat1['catId'] == $cat['subCatOf']) $selected= ' selected="selected"';
						$content .= "<option value=\"{$cat1['catId']}\"$selected>{$cat1['catName']}</option>";
					}
					$desc = nl2br($cat['catDesc']);
					$content .= "
							</select>
						</div>
						<div style=\"float:left; margin-right: 5px;\">
							<strong>Description: (optional)</strong><br/>
							<textarea name=\"new_desc\" id=\"new_desc\" rows=\"3\" cols=\"40\" />{$desc}</textarea>
						</div>
						<div style=\"float:left; margin-right: 5px;\">
							<input type=\"hidden\" name=\"catid\" id=\"catid\" value=\"{$cat['catId']}\"/><input type=\"button\" name=\"save\" id=\"save\" value=\"Save Changes\" onclick=\"addCat('{$_SESSION['key']}')\" style=\"margin-top: 15px; height: 52px; width: 150px;\" />
						</div>
						<div style=\"clear:left;\" id=\"new_cat_message\"></div>
					</form>";
		}
		$content .= '
				</div>';
		echo $content;
	}
	
	function show_news()
	{
		$preview = "";
		if ($this->vars['preview']=='true')
		{
			$content .= '
			<div style="text-align: center; margin-top: 3px;"><a href="?module=EJ_news&action=admin_page"><img src="'.$this->moduleloc.'back.png" alt="Back to news" title="Back to news" style="border:0;" /></a></div>
			<h2  class="EJN"><img src="'.$this->moduleloc.'calendar.jpg"/> news Preview</h2>';
			$preview = "&preview=true";
		}
		if (!isset($this->vars['newsid']))
		{
			$content = "<p class=\"EJ_userError\"><strong>ERROR:</strong> news Not Found! Please go back and try again.</p>";
		} else
		{
			$this->EJ_mysql->query("SELECT *, (SELECT catName FROM {$this->EJ_mysql->prefix}module_EJ_news_cats WHERE catId = EJ_newsCat) as category FROM {$this->EJ_mysql->prefix}module_EJ_news WHERE EJ_newsId = {$this->vars['newsid']}");
			if ($this->EJ_mysql->numRows() == 0)
			{
				$content = "<p class=\"EJ_userError\"><strong>ERROR:</strong> news Not Found! Please go back and try again.</p>";
			} else
			{
				$news = $this->EJ_mysql->getRow();
				$this->EJ_mysql->query("UPDATE {$this->EJ_mysql->prefix}module_EJ_news SET EJ_newsHits = EJ_newsHits + 1 WHERE EJ_newsId = {$this->vars['newsid']}");
				$news['EJ_newsHits']++;
				$content .= '
				<div id="news_left">';
				if (!empty($news['EJ_newsImage']) and file_exists($_SERVER['DOCUMENT_ROOT'].$this->settings['instloc'].$this->moduleloc.'images/'.$news['EJ_newsImage']))
				{
					$content .= '
					<img src="'.$this->settings['instloc'].$this->moduleloc.'image.php'.$this->settings['instloc'].$this->moduleloc.'images/'.$news['EJ_newsImage'].'?width=250&amp;image='.$this->settings['instloc'].$this->moduleloc.'images/'.$news['EJ_newsImage'].'" alt="'.urlencode($news['EJ_newsTitle']).'" />';
				} else
				{
					$content .= '
					<img src="'.$this->settings['instloc'].$this->moduleloc.'image.php'.$this->settings['instloc'].$this->moduleloc.'images/noimage.png?width=250&amp;image='.$this->settings['instloc'].$this->moduleloc.'images/noimage.png" alt="'.urlencode($news['EJ_newsTitle']).'" />';
				}
				$content .= '<br/>
					<a class="back_calendar" href="?module=EJ_news&action=news_calendar'.$preview.'">&lt;&lt; Back to Calendar</a>';
				$content .= '
				</div>';
				$content .= '
				<div id="news_right">
					<h2  class="EJN"><span style="float:right;">Hits: '.$news['EJ_newsHits'].'</span>'.date('d/m/Y', strtotime($news['EJ_newsDate'])).' - '.$news['EJ_newsTitle'].'</h2>
					<p><strong>news Category:</strong> '.$news['category'].'</p>
					<p>'.str_replace(array('£','%u2019'), array('&pound;',"'"), $news['EJ_newsText']).'</p>
					<p><strong>news Starts:</strong> '.$news['EJ_newsTime'].' on '.date('D d M Y', strtotime($news['EJ_newsDate'])).'</p>
					<p><strong>Location:</strong> '.$news['EJ_newsLoc1'];
				if (!empty($news['EJ_newsLoc2']))
				{
					$content .= ', '.$news['EJ_newsLoc2'];
				}
				if (!empty($news['EJ_newsLoc3']))
				{
					$content .= ', '.$news['EJ_newsLoc3'];
				}
				if (!empty($news['EJ_newsLoc4']))
				{
					$content .= ', '.$news['EJ_newsLoc4'];
				}
				if (!empty($news['EJ_newsLoc5']))
				{
					$content .= ', '.$news['EJ_newsLoc5'];
				}
				$content .= '
					<p><strong>For Details Contact:</strong> <a href="mailto:'.$news['EJ_newsContact'].'">'.$news['EJ_newsContact'].'</a></p>';
				$content .='
					</p>';
				$content .= '
				</div>';
			}
		}
		$content .= '<div style="clear: both;"></div>';
		echo $content;
	}
	
	function news_summary($artcount = "5", $charcount = "150")
	{
		$count=0;
		$this->EJ_mysql->query("SELECT * FROM {$this->EJ_mysql->prefix}module_EJ_news WHERE EJ_newsHidden = 0 ORDER BY EJ_newsDate DESC LIMIT $artcount");
		while ($news = $this->EJ_mysql->getRow())
		{
			if (strrpos($news['EJ_newsLoc'],"(")!=0)
			{
				$news['locName'] = "Multiple Locations";
			}
			if (!empty($news['EJ_newsImages']) and file_exists(dirname(__FILE__)."/EJ_news/images/{$news['EJ_newsId']}/{$news['EJ_newsImages']}"))
			{
				$image = "<img src=\"{$this->settings['instloc']}{$this->moduleloc}image.php/{$news['EJ_newsImages']}?image={$this->EJ_settings['instloc']}{$this->moduleloc}images/{$news['EJ_newsId']}/{$news['EJ_newsImages']}&amp;height=60&amp;width=80\" alt=\"{$news['EJ_newsTitle']}\"/>";
			} else
			{
				$image = "<img src=\"{$this->settings['instloc']}{$this->moduleloc}image.php/noimage.png?image={$this->settings['instloc']}{$this->moduleloc}images/noimage.png&amp;height=60&amp;width=80\" alt=\"{$news['EJ_newsTitle']}\"/>";
			}
			if ($count==0)
			{
				$content .= "<div class=\"EJ_newsSummary\" id=\"{$news['EJ_newsId']}\"><div style=\"float: left; margin: 0 5px;\"><div class=\"EJ_newsSummaryImageHolder\"><a href=\"?module=EJ_news&action=show_news&newsId={$news['EJ_newsId']}\">$image</a></div></div><div class=\"header\"><a href=\"?module=EJ_news&action=show_news&newsId={$news['EJ_newsId']}\">{$news['EJ_newsTitle']}</a></div><p>".str_replace(array('<br>','<br/>','<br />', "\n")," ",substr($news['EJ_newsText'],0,$charcount))."... <a href=\"?module=EJ_news&action=show_news&newsId={$news['EJ_newsId']}\">more</a></p><div style=\"clear: left;\"></div></div>";
			} else
			{
				$content .= "<div class=\"EJ_newsSummary\" id=\"{$news['EJ_newsId']}\"><div class=\"header\"><a href=\"?module=EJ_news&action=show_news&newsId={$news['EJ_newsId']}\">{$news['EJ_newsTitle']}</a></div></div>";
			}
			$count++;
		}
		if ($count==0)
			$content = "<p>No News Found!</p>";
		echo $content;

	}
}
} else
{
	EJ_error(41, basename(__FILE__));
}

?>