import React from 'react';
import ReactDOM from 'react-dom'
// import App from './components/App'
import Root from './components/Root'

if (document.getElementById('app')) {
    ReactDOM.render(<Root />, document.getElementById('app'))
}
