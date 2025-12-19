import MenuController from './MenuController'
import PageController from './PageController'

const Admin = {
    MenuController: Object.assign(MenuController, MenuController),
    PageController: Object.assign(PageController, PageController),
}

export default Admin