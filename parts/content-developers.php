<?php  
$banner_image = get_field('banner_image');
$banner_text = get_field('banner_text');
$banner_tabs = get_field('tabs');
if($banner_image) { ?>
<div class="custom-banner">
  <div class="image" style="background-image:url('<?php echo $banner_image['url'] ?>')"></div>
  <div class="banner-inner container">
    <?php if ($banner_tabs) { ?>
    <div class="banner-tabs">
      <?php foreach ($banner_tabs as $b) { ?>
        <?php if ($b['title'] && $b['link']) { ?>
          <a href="<?php echo $b['link'] ?>"><?php echo $b['title'] ?></a>
        <?php } ?>
      <?php } ?>
    </div> 
    <?php } ?>

    <?php if ($banner_text) { ?>
    <div class="banner-text">
      <div class="text"><?php echo $banner_text ?></div>
    </div> 
    <?php } ?>
  </div>
</div>
<?php } ?>


<?php if( $intro = get_field('intro') ) { ?>
<div class="section-intro">
  <div class="wrap"><?php echo $intro ?></div>
</div>
<?php } ?>

<?php if ( $icons = get_field('icons') ) { ?>
<div class="section-icons">
  <div class="wrap">
    <div class="flex">
    <?php foreach ($icons as $icon) { ?>
      <?php if ($icon['title']) { ?>
      <div class="item">
        <?php if ($icon['icon']) { ?>
        <figure class="icon" style="background-image:url('<?php echo $icon['icon']['url'] ?>')"></figure> 
        <?php } ?>
        <?php if ($icon['title']) { ?>
        <div class="text"><?php echo $icon['title'] ?></div> 
        <?php } ?>
      </div>
      <?php } ?>
    <?php } ?>
    </div>
  </div>
</div>
<?php } ?>


<?php if( $intro = get_field('types') ) { ?>
  <?php if( have_rows('types') ) { ?>
  <div class="section-flexible-content">
    <div class="wrapper">
    <?php $n=1; while ( have_rows('types') ) : the_row(); ?>
      <?php if( get_row_layout() == 'type' ) { 
        $title = get_sub_field('title');
        $tabid = (get_sub_field('id')) ? get_sub_field('id') : 'tab-'.$n;
        $feature_type = get_sub_field('feature_type');
        $feat_image = get_sub_field('feat_image');
        $video_thumbnail = get_sub_field('video_thumbnail');
        $video_url = get_sub_field('video_url');
        $information = get_sub_field('information');
        $counter = get_sub_field('counter');
        $carousel = get_sub_field('carousel');
        $visibility = get_sub_field('visibility');
        $imageURL = '';
        $videoType = '';
        if($feature_type=='image') {
          $imageURL = $feat_image['url'];
        } else {
          $imageURL = $video_thumbnail['url'];
          if($video_url) {
            $videoURLParts = explode("/",$video_url);
            if( strpos( strtolower($video_url), 'vimeo.com') !== false ) {
              $videoType = ' vimeo';
              $parts = ($videoURLParts && array_filter($videoURLParts) ) ? array_filter($videoURLParts) : '';
              $vimeoId = ($parts) ?  preg_replace('/\s+/', '', end($parts)) : '';
            }
            else if( strpos( strtolower($video_url), 'youtube.com') !== false || strpos( strtolower($video_url), 'youtu.be') ) {
              $videoType = ' youtube';
              /* if iframe */
              if (strpos( strtolower($video_url), 'youtube.com/embed') !== false) {
                $parts = extractURLFromString($video_url);
                $youtubeId = basename($parts);
              } else {
                $youtubeId = (isset($query['v']) && $query['v']) ? $query['v']:''; 
              }
            }
          }
        }
        if($visibility=='show') { ?>
        <div id="<?php echo $tabid ?>" class="flex-content feattype_<?php echo $feature_type.$videoType  ?>">
          <?php if ($title) { ?>
            <h2 class="t1"><?php echo $title ?></h2>
          <?php } ?>
          <div class="flexwrap">
            <div class="fxcol fxleft">
              <div class="imagebox">
                <?php if ($imageURL) { ?>
                <div class="img" style="background-image:url('<?php echo $imageURL ?>')"></div> 
                <?php } ?>
                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/resizer.png" alt="">
              </div>
              <?php if ($counter) { ?>
              <div class="counter">
                <?php foreach ($counter as $c) { ?>
                  <?php if ($c['count_number']) { ?>
                  <div class="count">
                    <div class="cnum"><span><?php echo $c['count_number'] ?></span></div>
                    <div class="ctext"><span><?php echo $c['count_title'] ?></span></div>
                  </div> 
                  <?php } ?>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
            <div class="fxcol fxright">
              <?php if ($information) { ?>
                <div class="info"><?php echo $information ?></div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } ?>
      <?php $n++; } ?>
    <?php endwhile; ?>
    </div>
  </div>
  <?php } ?>
<?php } ?>
