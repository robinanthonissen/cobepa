//import '@babel/polyfill'
import 'nodelist-foreach-polyfill'

const cPopup = () => {

  const _html = document.documentElement
  const popupTriggers = document.querySelectorAll('.js-c-popup-trigger')
  const popupCloses = document.querySelectorAll('.js-c-popup-close')

  popupTriggers.forEach((popupTrigger, index) => {
    popupTrigger.addEventListener('click', function (e) {
			e.preventDefault()
      const popupId = popupTrigger.dataset.popup
      _html.classList.add('c-popup-is-active')
      const popup = document.querySelector('[data-popup-id="' + popupId + '"]')
      popup.classList.add('is-active')
    })
  })

  popupCloses.forEach((popupClose, index) => {
    popupClose.addEventListener('click', function (e) {
			e.preventDefault()
      const popupId = popupClose.parentElement.dataset.popupId
      _html.classList.remove('c-popup-is-active')
      const popup = document.querySelector('[data-popup-id="' + popupId + '"]')
      popup.classList.remove('is-active')
    })
  })

}

export default cPopup
