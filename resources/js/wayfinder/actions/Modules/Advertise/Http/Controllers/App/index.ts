import CategoryController from './CategoryController'
import StateController from './StateController'
import AdvertisementController from './AdvertisementController'
import AdvertisementGalleryController from './AdvertisementGalleryController'
import CategoryAttributeController from './CategoryAttributeController'
import CategoryValueController from './CategoryValueController'

const App = {
    CategoryController: Object.assign(CategoryController, CategoryController),
    StateController: Object.assign(StateController, StateController),
    AdvertisementController: Object.assign(AdvertisementController, AdvertisementController),
    AdvertisementGalleryController: Object.assign(AdvertisementGalleryController, AdvertisementGalleryController),
    CategoryAttributeController: Object.assign(CategoryAttributeController, CategoryAttributeController),
    CategoryValueController: Object.assign(CategoryValueController, CategoryValueController),
}

export default App