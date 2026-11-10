//import '@babel/polyfill'

var Blazy = require('blazy')

const lazyLoad = () => {

  var bLazy = new Blazy({
    selector: '.lazy',
    successClass: 'is-loaded',
    offset: 300,
    success: function (element) {
      element.parentElement.classList.add('is-loaded')
    }
  })

}

export default lazyLoad
