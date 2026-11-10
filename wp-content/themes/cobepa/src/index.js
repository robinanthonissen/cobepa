import './css/app.scss'

/* -----------------------------------------
  IMPORT JS
----------------------------------------- */

// Utility
import browserClasses from './js/utils/bowser'
import lazyLoad from './js/utils/lazy'
import { isInView, isInViewVideo } from './js/utils/inview'
import windowHeightInit from './js/utils/window-height'

// Components
import cHeaderInit from './js/components/c-header'
import cMenuInit from './js/components/c-menu'
import cPopup from './js/components/c-popup'
import cTabs from './js/components/c-tabs'
import cToggleBlock from './js/components/c-toggle-block'

// Pages
//import this from './js/pages/home'

/* -----------------------------------------
  INIT
----------------------------------------- */

const initScripts = {

	init: function () {
		// Utility
		browserClasses()
		lazyLoad()
		isInView()
		isInViewVideo()
		windowHeightInit()

		// Components
		cHeaderInit()
		cMenuInit()
		cPopup()
		cTabs()
		cToggleBlock()

		// Pages
		// this()
  	}

}
initScripts.init()
