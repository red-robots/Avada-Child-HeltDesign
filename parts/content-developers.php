<?php  
$banner_image = get_field('banner_image');
$banner_text = get_field('banner_text');
$banner_tabs = get_field('tabs');
if($banner_image) { ?>
<div class="custom-banner">
  <div class="image" style="background-image:url('<?php echo $banner_image['url'] ?>')"></div>
  <div class="banner-inner container">
    <div id="bannerTabs" class="banner-tabs"></div>
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
    <?php $n=1; while ( have_rows('types') ) : the_row(); ?>
      <?php if( get_row_layout() == 'type' ) { 
        $title = get_sub_field('title');
        $divId = ($title) ? sanitize_title($title) : '';
        //$tabid = (get_sub_field('id')) ? get_sub_field('id') : 'tab-'.$n;
        $feature_type = get_sub_field('feature_type');
        $feat_image = get_sub_field('feat_image');
        $video_thumbnail = get_sub_field('video_thumbnail');
        $video_url = get_sub_field('video_url');
        $videoURL = ($video_url) ? $video_url : 'javascript:void(0)';
        $information = get_sub_field('information');
        $counter = get_sub_field('counter');
        $carousel = get_sub_field('carousel');
        $testimonial = get_sub_field('testimonial');
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

        <div id="tab_<?php echo $divId ?>" data-title="<?php echo $title ?>" class="flex-content feattype_<?php echo $feature_type.$videoType  ?>">
          
          <?php if ($title) { ?>
            <h2 class="t1"><?php echo $title ?></h2>
          <?php } ?>
          <div class="wrapper">
            <div class="flexwrap image-text-section">
              <div class="fxcol fxleft">
                <div class="wrap">
                  <div class="imagebox type-<?php echo $feature_type ?>">
                    <?php if ($feature_type=='video') { ?>
                      <a class="fancybox" href="<?php echo $videoURL ?>">
                        <span class="player"></span>
                        <?php if ($imageURL) { ?>
                        <div class="img" style="background-image:url('<?php echo $imageURL ?>')"></div> 
                        <?php } ?>
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/resizer.png" alt="">
                      </a>
                    <?php } else { ?>
                      <?php if ($imageURL) { ?>
                      <div class="img" style="background-image:url('<?php echo $imageURL ?>')"></div> 
                      <?php } ?>
                      <img src="<?php echo get_stylesheet_directory_uri() ?>/img/resizer.png" alt="">
                    <?php } ?>
                  </div>
                  <?php if ($counter) { ?>
                  <div class="counter">
                    <?php foreach ($counter as $c) { ?>
                      <?php if ($c['count_number']) { ?>
                      <div class="count">
                        <div class="cnum"><span count="up" data-count-duration="2200" class="animate-count"><?php echo $c['count_number'] ?></span></div>
                        <div class="ctext"><span><?php echo $c['count_title'] ?></span></div>
                      </div> 
                      <?php } ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="fxcol fxright">
                <?php if ($information) { ?>
                  <div class="info"><?php echo $information ?></div>
                <?php } ?>
              </div>
            </div>
          </div>
        
          <?php if ($carousel) { ?>
          <div class="section-carousel">
            <div class="loop owl-carousel owl-theme carouselcontent">
            <?php foreach ($carousel as $img) { ?>
              <div class="item">
                <figure style="background-image:url('<?php echo $img['url'] ?>')">
                  <!-- <img src="<?php //echo get_stylesheet_directory_uri() ?>/img/resizer.png" alt=""> -->
                </figure>
              </div>
            <?php } ?>
            </div>
          </div>
          <?php } ?>

          <?php if ( isset($testimonial['author']) && $testimonial['message'] ) { ?>
          <div class="section-testimonial">
            <div class="container">
              <div class="testimonial">
                <div class="message"><?php echo $testimonial['message'] ?></div>
                <div class="author"><?php echo $testimonial['author'] ?></div>
              </div>
            </div>
          </div>    
          <?php } ?>

          <?php /* BEFORE AND AFTER */ ?>
          <?php if( $beforeAfter = get_sub_field('beforeAfter') ) { ?>
          <div class="section-before-and-after" data-bacount="<?php echo count($beforeAfter) ?>">
            <div class="section-before-inner inner">
              <div class="baTabs" data-resizer="<?php echo get_stylesheet_directory_uri() ?>/img/resizer.png">
                <div class="owl-carousel owl-theme before-after-carousel">
                <?php $x=1; foreach ($beforeAfter as $b) { 
                  $logo = $b['logo'];
                  $beforeImg = ($b['before_image']) ? $b['before_image']['url'] : '';
                  $afterImg = ($b['after_image']) ? $b['after_image']['url'] : '';
                  $isActive = ($x==1) ? ' active':'';
                  if($logo && ($beforeImg && $afterImg) ) { ?>
                  <div class="info<?php echo $isActive?>">
                    <a href="javascript:void(0)" class="ba_tab" data-id="batab-<?php echo $x ?>" data-before-img="<?php echo $beforeImg ?>" data-after-img="<?php echo $afterImg ?>"><figure style="background-image:url('<?php echo $logo['url'] ?>')"></figure></a>
                  </div>
                  <?php $x++; } ?>
                <?php } ?>
                </div>
              </div>
              <div class="ba-image-container"></div>
            </div>
          </div>
          <?php } ?>

          
          <div class="divider"><div class="wrapper"><div class="border-bottom"></div></div></div>

        </div>

        <?php } ?>

      <?php $n++; } ?>

    <?php endwhile; ?>
    </div>
  </div>
  <?php } ?>
<?php } ?>


<?php if( $calloutMessage = get_field('callout_message') ) { 
  $caBtn = get_field('callout_button');
  $ctaTitle = ( isset($caBtn['title']) && $caBtn['title'] ) ? $caBtn['title'] : '';
  $ctaLink = ( isset($caBtn['url']) && $caBtn['url'] ) ? $caBtn['url'] : '';
  $ctaTarget = ( isset($caBtn['target']) && $caBtn['target'] ) ? $caBtn['target'] : '_self';
  ?>
<div class="section-bottom-callout">
  <div class="container">
    <div class="callout-message"><?php echo $calloutMessage ?></div>
    <?php if ($ctaTitle  && $ctaLink) { ?>
    <div class="buttondiv">
      <a href="<?php echo $ctaLink ?>" target="<?php echo $ctaTarget ?>" class="button"><?php echo $ctaTitle ?></a>
    </div> 
    <?php } ?>
  </div>
</div>
<?php } ?>