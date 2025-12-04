import AdvertisementController from './AdvertisementController'
import GalleryController from './GalleryController'
import AdvertisementNoteController from './AdvertisementNoteController'
import FavoriteAdvertisementController from './FavoriteAdvertisementController'
import HistoryAdvertisementController from './HistoryAdvertisementController'

const Panel = {
    AdvertisementController: Object.assign(AdvertisementController, AdvertisementController),
    GalleryController: Object.assign(GalleryController, GalleryController),
    AdvertisementNoteController: Object.assign(AdvertisementNoteController, AdvertisementNoteController),
    FavoriteAdvertisementController: Object.assign(FavoriteAdvertisementController, FavoriteAdvertisementController),
    HistoryAdvertisementController: Object.assign(HistoryAdvertisementController, HistoryAdvertisementController),
}

export default Panel