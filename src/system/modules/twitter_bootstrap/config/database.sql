-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_content`
-- 

CREATE TABLE `tl_content` (
  `bootstrapSliderType` varchar(255) NOT NULL default '',
  `bootstrapSliderInterval` int(10) unsigned NOT NULL default '0',
  `bootstrapSliderPause` varchar(255) NOT NULL default '',
  `bootstrapSliderTitle` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;