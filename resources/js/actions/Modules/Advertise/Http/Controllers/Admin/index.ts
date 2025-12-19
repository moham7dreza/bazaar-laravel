import CategoryController from './CategoryController'
import GalleryController from './GalleryController'
import StateController from './StateController'
import CategoryAttributeController from './CategoryAttributeController'
import CategoryValueController from './CategoryValueController'
import AdvertisementController from './AdvertisementController'

const Admin = {
    CategoryController: Object.assign(CategoryController, CategoryController),
    GalleryController: Object.assign(GalleryController, GalleryController),
    StateController: Object.assign(StateController, StateController),
    CategoryAttributeController: Object.assign(CategoryAttributeController, CategoryAttributeController),
    CategoryValueController: Object.assign(CategoryValueController, CategoryValueController),
    AdvertisementController: Object.assign(AdvertisementController, AdvertisementController),
}

export default Admin