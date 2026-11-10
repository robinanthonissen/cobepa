import 'nodelist-foreach-polyfill'

const OPEN_CLASS = 'c-menu-is-open'

const cMenuInit = () => {
  const menu = document.querySelector('.c-menu')
  const menuButtons = document.querySelectorAll('.js-c-menu-button')
  const toggle = document.querySelector('.l-header__toggle')

  if (!menu || !menuButtons.length) return

  const focusables = () => menu.querySelectorAll('a, button')

  const setOpen = (open) => {
    document.documentElement.classList.toggle(OPEN_CLASS, open)
    menu.setAttribute('aria-hidden', open ? 'false' : 'true')
    if (toggle) toggle.setAttribute('aria-expanded', open ? 'true' : 'false')

    // Links in het gesloten menu niet bereikbaar met Tab
    focusables().forEach(el => el.setAttribute('tabindex', open ? '0' : '-1'))

    if (open) {
      const close = menu.querySelector('.c-menu__close')
      if (close) close.focus()
    } else if (toggle) {
      toggle.focus()
    }
  }

  const isOpen = () => document.documentElement.classList.contains(OPEN_CLASS)

  menuButtons.forEach(button => {
    button.addEventListener('click', () => setOpen(!isOpen()))
  })

  // Sluiten met Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen()) setOpen(false)
  })

  // Sluiten bij resize naar desktop
  const mq = window.matchMedia('(min-width: 1024px)')
  const onChange = (e) => { if (e.matches && isOpen()) setOpen(false) }
  if (mq.addEventListener) mq.addEventListener('change', onChange)
  else if (mq.addListener) mq.addListener(onChange)
}

export default cMenuInit
