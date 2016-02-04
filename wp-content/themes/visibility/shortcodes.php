<?php
add_shortcode('div', 'div_shortcode_init');
function div_shortcode_init( $atts, $content = null){
  $class = '';
  $id = '';
  $style = '';
  $itemprop = '';
  $itemscope = '';
  $itemtype = '';
  extract(shortcode_atts(array(
    'class' => '',
    'id' => '',
    'style' => '',
    'itemprop' => '',
    'itemscope' => '',
    'itemtype' => ''
  ),$atts));
  $output = '<div'.($class != '' ? ' class="'.$class.'"' : '').($id != '' ? ' id="'.$id.'"' : '').($style != '' ? ' style="'.$style.'"' : '').($itemprop != '' ? ' itemprop="'.$itemprop.'"' : '').($itemscope != '' ? ' itemscope' : '').($itemtype != '' ? ' itemtype="'.$itemtype.'"' : '').'>';
  return $output;
}
add_shortcode('enddiv', 'enddiv_shortcode_init');
function enddiv_shortcode_init( $atts, $content = null){
  $output = '</div>';
  return $output;
}
add_shortcode('span', 'span_shortcode_init');
function span_shortcode_init( $atts, $content = null){
  $class = '';
  $id = '';
  $style = '';
  $itemprop = '';
  $itemscope = '';
  $itemtype = '';
  extract(shortcode_atts(array(
    'class' => '',
    'id' => '',
    'style' => '',
    'itemprop' => '',
    'itemscope' => '',
    'itemtype' => ''
  ),$atts));
  $output = '<span'.($class != '' ? ' class="'.$class.'"' : '').($id != '' ? ' id="'.$id.'"' : '').($style != '' ? ' style="'.$style.'"' : '').($itemprop != '' ? ' itemprop="'.$itemprop.'"' : '').($itemscope != '' ? ' itemscope' : '').($itemtype != '' ? ' itemtype="'.$itemtype.'"' : '').'>';
  return $output;
}
add_shortcode('endspan', 'endspan_shortcode_init');
function endspan_shortcode_init( $atts, $content = null){
  $output = '</span>';
  return $output;
}
add_shortcode('a', 'a_shortcode_init');
function a_shortcode_init( $atts, $content = null){
  $href = '';
  $target = '';
  $class = '';
  $id = '';
  $style = '';
  $itemprop = '';
  $itemscope = '';
  $itemtype = '';
  extract(shortcode_atts(array(
    'href' => '',
    'target' => '',
    'class' => '',
    'id' => '',
    'style' => '',
    'itemprop' => '',
    'itemscope' => '',
    'itemtype' => ''
  ),$atts));
  $output = '<a'.($href != '' ? ' href="'.$href.'"' : '').($class != '' ? ' class="'.$class.'"' : '').($id != '' ? ' id="'.$id.'"' : '').($style != '' ? ' style="'.$style.'"' : '').($target != '' ? ' target="'.$target.'"' : '').($itemprop != '' ? ' itemprop="'.$itemprop.'"' : '').($itemscope != '' ? ' itemscope' : '').($itemtype != '' ? ' itemtype="'.$itemtype.'"' : '').'>';
  return $output;
}
add_shortcode('enda', 'enda_shortcode_init');
function enda_shortcode_init( $atts, $content = null){
  $output = '</a>';
  return $output;
}
add_shortcode('p', 'p_shortcode_init');
function p_shortcode_init( $atts, $content = null){
  $class = '';
  $id = '';
  $style = '';
  $itemprop = '';
  $itemscope = '';
  $itemtype = '';
  extract(shortcode_atts(array(
    'class' => '',
    'id' => '',
    'style' => '',
    'itemprop' => '',
    'itemscope' => '',
    'itemtype' => ''
  ),$atts));
  $output = '<p'.($class != '' ? ' class="'.$class.'"' : '').($id != '' ? ' id="'.$id.'"' : '').($style != '' ? ' style="'.$style.'"' : '').($itemprop != '' ? ' itemprop="'.$itemprop.'"' : '').($itemscope != '' ? ' itemscope' : '').($itemtype != '' ? ' itemtype="'.$itemtype.'"' : '').'>';
  return $output;
}
add_shortcode('endp', 'endp_shortcode_init');
function endp_shortcode_init( $atts, $content = null){
  $output = '</p>';
  return $output;
}
add_shortcode('br', 'br_shortcode_init');
function br_shortcode_init( $atts, $content = null){
  $output = '<br>';
  return $output;
}
?>