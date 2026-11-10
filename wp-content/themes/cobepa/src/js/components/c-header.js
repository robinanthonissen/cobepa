import 'nodelist-foreach-polyfill'

// Voegt .collapsed toe zodra er voorbij de header gescrold wordt (schaduw + lagere header)
const cHeaderInit = () => {
    const header = document.querySelector('.js-l-header')
    if (!header) return

    const threshold = header.offsetHeight + 40
    let ticking = false

    const update = () => {
        header.classList.toggle('collapsed', window.scrollY >= threshold)
        ticking = false
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(update)
            ticking = true
        }
    }, { passive: true })

    update()
}

export default cHeaderInit
