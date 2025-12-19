import FolderResource from './FolderResource'
import MediaResource from './MediaResource'

const Resources = {
    FolderResource: Object.assign(FolderResource, FolderResource),
    MediaResource: Object.assign(MediaResource, MediaResource),
}

export default Resources