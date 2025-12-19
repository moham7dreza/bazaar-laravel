import MenuController from './MenuController'
import PageController from './PageController'

const App = {
    MenuController: Object.assign(MenuController, MenuController),
    PageController: Object.assign(PageController, PageController),
}

export default App