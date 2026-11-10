//import '@babel/polyfill'
import 'nodelist-foreach-polyfill'
import lazyLoad from './../utils/lazy'

const cToggleBlock = () => {

  const toggleBlocks = document.querySelectorAll('.js-c-toggle-block-trigger')

  if ( toggleBlocks != null ) {

    toggleBlocks.forEach((toggleBlock, index) => {
      toggleBlock.addEventListener('click', function () {
        if (toggleBlock.parentNode.classList.contains('is-active')) {
					toggleBlock.parentNode.classList.remove('is-open')
          toggleBlock.parentNode.classList.remove('is-active')
        } else {
          toggleBlock.parentNode.classList.add('is-active')
					setTimeout(function () {
						toggleBlock.parentNode.classList.add('is-open');
						lazyLoad();
					}, 20);
        }
      })
    })

  }

}

export default cToggleBlock
