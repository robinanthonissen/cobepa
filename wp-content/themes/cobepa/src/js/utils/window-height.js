//import '@babel/polyfill'

const windowHeightInit = () => {

	const windowHeightCalc = () => {
		let vh = window.innerHeight * 0.01;
		document.documentElement.style.setProperty('--vh', `${vh}px`);
	}
	windowHeightCalc()

	window.addEventListener('resize', () => {
		windowHeightCalc()
	});

}

export default windowHeightInit
