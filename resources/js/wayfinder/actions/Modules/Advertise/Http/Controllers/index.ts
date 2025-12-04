import App from './App'
import Admin from './Admin'
import Panel from './Panel'

const Controllers = {
    App: Object.assign(App, App),
    Admin: Object.assign(Admin, Admin),
    Panel: Object.assign(Panel, Panel),
}

export default Controllers