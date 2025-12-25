import mails from './mails'
import auth from './auth'
import pages from './pages'
import resources from './resources'

const superAdmin = {
    mails: Object.assign(mails, mails),
    auth: Object.assign(auth, auth),
    pages: Object.assign(pages, pages),
    resources: Object.assign(resources, resources),
}

export default superAdmin