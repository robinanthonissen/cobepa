//import '@babel/polyfill'
import 'nodelist-foreach-polyfill'
import lazyLoad from './../utils/lazy'

const cTabs = () => {

	const allTabs = document.querySelectorAll('.js-c-tabs')

	if ( allTabs != null ) {

		allTabs.forEach( (tabs, index) => {

	  const tabsTab = tabs.querySelectorAll('.c-tabs__tab')

		  function myTabClicks (tabClickEvent) {

		    for ( let i = 0; i < tabsTab.length; i++ ) {
		      tabsTab[i].classList.remove('is-active')
		    }

		    const clickedTab = tabClickEvent.currentTarget
		    clickedTab.classList.add('is-active')
		    const tabPanes = tabs.querySelectorAll('.js-c-tabs-content')

		    for ( let i = 0; i < tabPanes.length; i++ ) {
		      tabPanes[i].classList.remove('is-active');
					tabPanes[i].classList.remove('is-open');
		    }

		    const activeTab = clickedTab.dataset.tabs
		    const activePane = tabs.querySelector('[data-tabs-id="' + activeTab + '"]')
		    activePane.classList.add('is-active');
				setTimeout(function () {
					activePane.classList.add('is-open');
					lazyLoad();
				}, 20);

		  }

		  for ( let i = 0; i < tabsTab.length; i++ ) {
		    tabsTab[i].addEventListener('click', myTabClicks)
		  }

		});

	}

}

export default cTabs
