const linkColor = document.querySelectorAll('.nav__link')
const showNavbar = (toggleId, navId, bodyId, headerId, davatar, imgId, unameId, statId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId),
    bodypd = document.getElementById(bodyId),
    headerpd = document.getElementById(headerId),
    dimg = document.getElementById(davatar),
    img = document.getElementById(imgId),
    name = document.getElementById(unameId),
    status = document.getElementById(statId)

    if(toggle && nav && bodypd && headerpd){
        toggle.addEventListener('click', ()=>{
            nav.classList.toggle('show')
            bodypd.classList.toggle('body-pd')
            headerpd.classList.toggle('body-pd')
            dimg.classList.toggle('show')
            img.classList.toggle('show')
            name.classList.toggle('show')
            status.classList.toggle('show')
        })
    }
}
showNavbar('header-toggle','nav-bar','body-pd','header','user-a','user-a_img','user_p','user_s');
function sidebarIcon(){
    icon = document.getElementById('toggle-icon')
    iconClass = String(icon.classList)
    if(iconClass.includes("fa-bars")){
        icon.classList.toggle('fa-times')
    }else{
        icon.classList.toggle('fa-bars')
    }
    
}

function colorLink(){
    if(linkColor){
        linkColor.forEach(l => l.classList.remove('active'))
        this.classList.add('active')
    }
}


linkColor.forEach(l => l.addEventListener('click',colorLink))