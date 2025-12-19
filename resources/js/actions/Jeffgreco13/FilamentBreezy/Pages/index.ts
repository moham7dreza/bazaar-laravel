import MyProfilePage from './MyProfilePage'
import TwoFactorPage from './TwoFactorPage'

const Pages = {
    MyProfilePage: Object.assign(MyProfilePage, MyProfilePage),
    TwoFactorPage: Object.assign(TwoFactorPage, TwoFactorPage),
}

export default Pages