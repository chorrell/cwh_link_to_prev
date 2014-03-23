<?php
$plugin['name'] = 'cwh_link_to_prev';

$plugin['version'] = '0.1';
$plugin['author'] = 'Christopher Horrell';
$plugin['author_uri'] = 'http://horrell.ca/';
$plugin['description'] = 'A replacement tag for <txp:link_to_prev /> that includes the ability to set the output format as a <link> tag.';


$plugin['type'] = 0; 


@include_once('zem_tpl.php');

if (0) {
?>
# --- BEGIN PLUGIN HELP ---
This is a replacement tag for @<txp:link_to_prev />@ that includes a new _format_ attribute which provides the ability to set the link format as a @<link>@ tag suitable for placing in the @<head>@ of any individual article page on your site. You can do this by setting the _format_ attribute like so:

@<txp:cwh_link_to_home title="Home" format="link" />@

which will produce something similar to:

@<link rel="prev" href="http://example.com/article/1/previous-post" title="Previous Post" />@

Note that when used as a single tag without the _format_ attribute specified:

@<txp:cwh_link_to_prev />@ 

it will produce a plain text link much in the same way as @<txp:link_to_prev />@:

@http://example.com/article/1/previous-post@


Finally, it can also be used as a container tag in the same manner as @<txp:link_to_prev />@ if no _format_ value is specified:

@<txp:cwh_link_to_prev> ...Text or Tag... </txp:cwh_link_to_prev>@

If you do specify a _link_ value for the _format_ attribute while used as a container tag, it will still produce a @<link>@ tag.

This tag also shares all of the same attributes as @<txp:link_to_prev />@. For a complete list of applicable attributes, see "this Textbook entry":http://textbook.textpattern.net/wiki/index.php?title=Txp:link_to_prev.

For a further explanation of the benefits of using @<link>@ tags for your site's navigation, please see "Day 9: Providing additional navigation aids":http://diveintoaccessibility.org/day_9_providing_additional_navigation_aids.html from Mark Pilgrim's "
Dive Into Accessibility":http://diveintoaccessibility.org/.

# --- END PLUGIN HELP ---
<?php
}

# --- BEGIN PLUGIN CODE ---

function cwh_link_to_prev($atts, $thing) 
{
	global $id, $prev_id, $prev_title;

	extract(lAtts(array(
		'format'     => '', // new format attribute
		'showalways' => 0,
	), $atts));

	if (intval($id) == 0)
	{
		global $thisarticle, $s;

		extract(getNextPrev(
			$thisarticle['thisid'],
			@strftime('%Y-%m-%d %H:%M:%S', $thisarticle['posted']), 
			@$s
		));
	}

	if ($prev_id)
	{
		$url = permlinkurl_id($prev_id);

            if ($format == 'link')
			{
			    return '<link rel="prev" href="'.$url.'"'.
    				($prev_title != $thing ? ' title="'.$prev_title.'"' : '').' />';
			}
			
			
            elseif ($thing)
            {
                $thing = parse($thing);
                
			    return '<a rel="prev" href="'.$url.'"'.
				    ($prev_title != $thing ? ' title="'.$prev_title.'"' : '').
				    '>'.$thing.'</a>';
			}
			
            return $url;
	}

	return ($showalways) ? parse($thing) : '';
}


# --- END PLUGIN CODE ---

?>
