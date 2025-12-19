import App from './App'
import ImageController from './ImageController'
import Admin from './Admin'
import Examples from './Examples'
import FallbackController from './FallbackController'
import HomeController from './HomeController'
import SyncRolePermissionsController from './SyncRolePermissionsController'
import DomainRouterController from './DomainRouterController'

const Controllers = {
    App: Object.assign(App, App),
    ImageController: Object.assign(ImageController, ImageController),
    Admin: Object.assign(Admin, Admin),
    Examples: Object.assign(Examples, Examples),
    FallbackController: Object.assign(FallbackController, FallbackController),
    HomeController: Object.assign(HomeController, HomeController),
    SyncRolePermissionsController: Object.assign(SyncRolePermissionsController, SyncRolePermissionsController),
    DomainRouterController: Object.assign(DomainRouterController, DomainRouterController),
}

export default Controllers