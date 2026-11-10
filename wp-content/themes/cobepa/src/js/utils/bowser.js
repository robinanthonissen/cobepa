import Bowser from 'bowser'

const browserClasses = () => {

	const browser = Bowser.getParser(window.navigator.userAgent);

	document.documentElement.classList.add(`is-${browser.getPlatformType()}`);

	if ( browser.isBrowser("Internet Explorer") ) {
		document.documentElement.classList.add('is-ie');
	}
	if ( browser.isBrowser("Edge") ) {
		document.documentElement.classList.add('is-edge');
	}
	if ( browser.isBrowser("Chrome") ) {
		document.documentElement.classList.add('is-chrome');
	}
	if ( browser.isBrowser("Safari") ) {
		document.documentElement.classList.add('is-safari');
	}
	if ( browser.isBrowser("Firefox") ) {
		document.documentElement.classList.add('is-firefox');
	}

}

export default browserClasses
