<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 19:46
 */
?>
<header>
    <a href="/" class="logo">
        <img src="/img/logo.png" alt="Sosa logo">
    </a>

    <ul class="main-menu">
        @foreach($menuItems as $item)
            <li><a href="{{$item->link}}">{{$item->name}}</a></li>
        @endforeach
    </ul>

    <ul class="carpet-menu">
        <li class="login">
            <a
                    @auth href="{{url('/profile')}}" @endauth
            @guest href="{{url('/login')}}" @endguest>
                Login
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     preserveAspectRatio="xMidYMid" width="60" height="60" viewBox="0 0 60 60">
                    <image xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAA1CAMAAAAwEZgGAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABC1BMVEUAAABmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADMAAAC/BBH2AAAAV3RSTlMAED5cWkIYFGalrXAWhb21s7i7mQIwv1dK/Itsr6dxeWkO+mcFDRIDVOXBOMnD02oK241iZHbNlXxg2R4Iq48EgxxOGqlYsZNWUki5oSIgDN+biXS3LCqOQT7+AAAAAWJLR0QAiAUdSAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAASpJREFUSMftkNtagkAURjdBGVhRHsooOh+IwAzKMi0jzaws8VD/+79JomHDZ59w0V2suzUzi80M0QTcDM8LHvzsHIWTmBcxRkouhAaLwJK8vOIhp4B0JuR8dhVrP5ZbRzIkkKGwuoHNkEDFVjBQ/zoQsc3qDsRfDnG7Pt6d9/YPDo+GcMfaCfTTzHibG00Vdf/ZDTOPaejiGVHhHJZtX4ywL4vAFf+ttqDkUbz2d0u2hZsClWFUmN+7xV2V0XtIjFUMlMkJvoOIB1ZzwUurcKiGOrsk4ZFVLTCB6qgNgga79IQSq02kWW0Mg8A3EqlnVl9es8H5E8F04iAO4iAO4uDfBA5a0YPWIHiDGT0w8U5t1+10FSsCSrfjum2iXh+R6fe8OR9NISLaJ9EXqNh/gFHNLAIAAAAASUVORK5CYII="
                           x="182" y="1" width="48" height="53"/>
                    <image xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADcAAAAvCAMAAABwgKKCAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABSlBMVEUAAABmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADMAAABy/sphAAAAbHRSTlMAHCoaHgQyTmiJubV8XDY0WnqPalAQYN3fzcvFwWZU05M82ddKRLfbFr2/0T4Mx9XPCEx+DmR2SKcYpW6Vmalsm52ryVazKHSxJjqvhVLlFEY9Xp8Shwahga3DAiBYOHAsQiIkCoMwi5ejYi7GmkinAAAAAWJLR0QAiAUdSAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAAmdJREFUSMeVlutD0lAYxo8IUoCgifJuo2EMJnjbJAFFUIHQMhJL01LTyrLb8/9/7jhQYAzceT6c27Pfdu7vGOvVmGecOWvc4/U5GmMT/idPAwiGJsNeOxOZmg4Cz2aiETs8OxcDSbISV2ReeN7nqQlu3TlSDJjv69ALQlJLtctpfYGUiQcrk6WFRbXz2JIGWu5ifl5d6VaXV2GYnbKZgJHqWmsGNPW+kpPo5Xrv59eiREFrJEEidaXXWslrpr+DKQsF+ywVCRtetlkiStmtLUOZsgplVAan1y9je6fU06mudlG9y3w1zDmsSzEAoP7KwclJjT2e7eP1G6cFPajqb1UngzWh83QRReassSHtKYsLIsrEFLU4XZh7hwD/aF2YC8MosEMIcxPAIWstCnNHWH3PWAA54fE1eFrDB2Euy9M57fhEjCto1kYroyCGUXs/V/BRiAvh2MpPy+aWADYjVzsnMo+E+6mJyNjvFFtVmC233DbOHvZ7poTKqTvsE33OdGsn55i+cIPlSbns67WJHRfYF0pc2YZr0PWj2CRpA9fU10Sy+UhXrzXj22Dr91XMb47CQkkp7NR+E0B1byj14yedR5ytvRpqt0Owk18IhIe987KG+JWj4/0NfdgrudZ1ogOnITSQvRk5ZzJReqDRcw4pw0bLpJj9vrmNY8nHHpMCM9/XkK6j7mITthqQZnrqUwp0V6fF+wdGN8L/lVDyusF4PDkD3UcilXDmEuOLvEHUDlJHPO6K3HZ8HY8sjHRX5/JBfB2jzE9kClFcJv+jSUIYYxf8zwpZsU5amg3JTde3XJ/+jdhc/wEJX2PFXCu9fQAAAABJRU5ErkJggg=="
                           x="88" y="7" width="55" height="47"/>
                    <image xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC8AAAA1CAMAAADmtEJjAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABPlBMVEUAAABmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADMAAABML5gyAAAAaHRSTlMAMekzHnSVq3YEeMazqKFIm9F6HFa1ZUrdnwUSnIOvscpTRpqBpUxuiIV8k1yqWiytIieRYLm6Drtil3FyzHO9js9+cNZjXmxSjDidTr/Tj2aLQjbaFWQ3GDDfwchqjXWjrJkqPsMyWOfBmv8AAAABYktHRACIBR1IAAAACXBIWXMAAC4jAAAuIwF4pT92AAACCklEQVRIx82VaVvaUBCFp1aJkkXDjkKCCkGIFloWg4jYSqstDdoltVa7L87//wUNUFsxMyF+8Hl6Pt178uZmzuTmBoDQvZmh7kMgzc6FBBxKCM3PTqUXwi4sSrIiS6J7S3jBH19cQlWOREfjaERWcWnRD48JGE9cmyfiKMR4PCmk0ssTznI6JSQ5fEVJZTxmJqWsMHwWNcLVMMtk1XOrhL2a09eY5ddJfx3zZPUF1SB5Qy1QCQyUmFwSUgsVmXKGBRUJN48bDL9BBihhmeHLWCLbw/SZuRJGk+FNnCfcTdxi+C18QLiVqviQxB+J1Qrl1+j36DauRvr1RnObsLebVouuc4dMbOIOkyspqW2P2VYlg+Fh1+rs3cQ71i6wKnfVyWz7j7tPwEcH2NOf/p0903p46IfDkXtOqc+vntZxZ3MvePqw38Ccbtb/TF9mFXuA+jFzQJz0bWyaNz7htiJi/NVrL/2mZr3VI473gmGKWPX06J2ANteJ08zAPn4/YUUavfQZH6xoY/967pLdyYOfTrUPyr9Nmj+/+AhTJGP/arsfdC8S03BwNPw0HiX1wd5UHODs3DoZDULshzupz70vw7/NptV0AvHwdbSZTPYc8TwAvwF8F8QfAfnKz+oviLHHrFc6XkIL5cC8jK075+v/WT13y9fdvIXAfGG8vhMNJmdcz23UgtjMbXT5G/AkbR8jofbYAAAAAElFTkSuQmCC"
                           x="7" y="3" width="47" height="53"/>
                </svg>
            </a>
        </li>
        <li class="favorites">
            <a href="#">
                Favorites
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     preserveAspectRatio="xMidYMid" width="60" height="60" viewBox="0 0 60 60">
                    <image xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADcAAAAvCAMAAABwgKKCAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABSlBMVEUAAABmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADMAAABy/sphAAAAbHRSTlMAHCoaHgQyTmiJubV8XDY0WnqPalAQYN3fzcvFwWZU05M82ddKRLfbFr2/0T4Mx9XPCEx+DmR2SKcYpW6Vmalsm52ryVazKHSxJjqvhVLlFEY9Xp8Shwahga3DAiBYOHAsQiIkCoMwi5ejYi7GmkinAAAAAWJLR0QAiAUdSAAAAAlwSFlzAAALEgAACxIB0t1+/AAAAmdJREFUSMeVlutD0lAYxo8IUoCgifJuo2EMJnjbJAFFUIHQMhJL01LTyrLb8/9/7jhQYAzceT6c27Pfdu7vGOvVmGecOWvc4/U5GmMT/idPAwiGJsNeOxOZmg4Cz2aiETs8OxcDSbISV2ReeN7nqQlu3TlSDJjv69ALQlJLtctpfYGUiQcrk6WFRbXz2JIGWu5ifl5d6VaXV2GYnbKZgJHqWmsGNPW+kpPo5Xrv59eiREFrJEEidaXXWslrpr+DKQsF+ywVCRtetlkiStmtLUOZsgplVAan1y9je6fU06mudlG9y3w1zDmsSzEAoP7KwclJjT2e7eP1G6cFPajqb1UngzWh83QRReassSHtKYsLIsrEFLU4XZh7hwD/aF2YC8MosEMIcxPAIWstCnNHWH3PWAA54fE1eFrDB2Euy9M57fhEjCto1kYroyCGUXs/V/BRiAvh2MpPy+aWADYjVzsnMo+E+6mJyNjvFFtVmC233DbOHvZ7poTKqTvsE33OdGsn55i+cIPlSbns67WJHRfYF0pc2YZr0PWj2CRpA9fU10Sy+UhXrzXj22Dr91XMb47CQkkp7NR+E0B1byj14yedR5ytvRpqt0Owk18IhIe987KG+JWj4/0NfdgrudZ1ogOnITSQvRk5ZzJReqDRcw4pw0bLpJj9vrmNY8nHHpMCM9/XkK6j7mITthqQZnrqUwp0V6fF+wdGN8L/lVDyusF4PDkD3UcilXDmEuOLvEHUDlJHPO6K3HZ8HY8sjHRX5/JBfB2jzE9kClFcJv+jSUIYYxf8zwpZsU5amg3JTde3XJ/+jdhc/wEJX2PFXCu9fQAAAABJRU5ErkJggg=="
                           x="3" y="8" width="55" height="47"/>
                </svg>
            </a>
        </li>
        <li class="carpet">
            <a class="btn btn-primary" data-toggle="collapse" id="collapseCartButton" href="#collapseCarpet" role="button" aria-expanded="false"
               aria-controls="collapseCarpet">
                Korpa
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     preserveAspectRatio="xMidYMid" width="60" height="60" viewBox="0 0 60 60">
                    <image xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAA1CAMAAAAwEZgGAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABC1BMVEUAAABmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADNmADMAAAC/BBH2AAAAV3RSTlMAED5cWkIYFGalrXAWhb21s7i7mQIwv1dK/Itsr6dxeWkO+mcFDRIDVOXBOMnD02oK241iZHbNlXxg2R4Iq48EgxxOGqlYsZNWUki5oSIgDN+biXS3LCqOQT7+AAAAAWJLR0QAiAUdSAAAAAlwSFlzAAALEgAACxIB0t1+/AAAASpJREFUSMftkNtagkAURjdBGVhRHsooOh+IwAzKMi0jzaws8VD/+79JomHDZ59w0V2suzUzi80M0QTcDM8LHvzsHIWTmBcxRkouhAaLwJK8vOIhp4B0JuR8dhVrP5ZbRzIkkKGwuoHNkEDFVjBQ/zoQsc3qDsRfDnG7Pt6d9/YPDo+GcMfaCfTTzHibG00Vdf/ZDTOPaejiGVHhHJZtX4ywL4vAFf+ttqDkUbz2d0u2hZsClWFUmN+7xV2V0XtIjFUMlMkJvoOIB1ZzwUurcKiGOrsk4ZFVLTCB6qgNgga79IQSq02kWW0Mg8A3EqlnVl9es8H5E8F04iAO4iAO4uDfBA5a0YPWIHiDGT0w8U5t1+10FSsCSrfjum2iXh+R6fe8OR9NISLaJ9EXqNh/gFHNLAIAAAAASUVORK5CYII="
                           x="7" y="3" width="48" height="53"/>
                </svg>
                <div class="carpet-value"><span id="cartTotalInMenu">{{$cartTotal}}</span> <span class="valute">€</span></div>
            </a>
        </li>
        <li>@auth
                <form class="form-horizontal" method="POST" action="{{ route('logout') }}">
                    {{ csrf_field() }}
                    <button type="submit">LOGOUT</button>
                </form>
            @endauth
        </li>
    </ul>
</header>
