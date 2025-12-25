import advertisements from './advertisements'
import content from './content'
import users from './users'

const admin = {
    advertisements: Object.assign(advertisements, advertisements),
    content: Object.assign(content, content),
    users: Object.assign(users, users),
}

export default admin