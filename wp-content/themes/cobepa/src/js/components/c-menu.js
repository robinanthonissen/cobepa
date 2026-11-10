//import '@babel/polyfill'
import 'nodelist-foreach-polyfill'

const cMenuInit = () => {

  const menuButtons = document.querySelectorAll('.js-c-menu-button')

  menuButtons.forEach(menuButton => {
    menuButton.addEventListener('click', function (e) {
      document.documentElement.classList.toggle('c-menu-is-open')
    })
  })

}

export default cMenuInit
