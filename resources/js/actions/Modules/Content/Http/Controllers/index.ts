import App from './App'
import Admin from './Admin'

const Controllers = {
    App: Object.assign(App, App),
    Admin: Object.assign(Admin, Admin),
}

export default Controllers