import 'nodelist-foreach-polyfill'
//import Headroom from "headroom.js"

const cHeaderInit = () => {
    var header = document.querySelector("header")


    let scrollpos = window.scrollY
    const header_height = header.offsetHeight + 150

    window.addEventListener('scroll', function() { 
        scrollpos = window.scrollY;

        if (scrollpos >= header_height) {
            header.classList.add("collapsed")
        } else { 
            header.classList.remove("collapsed")
        }
    })

}

export default cHeaderInit