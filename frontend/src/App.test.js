import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';

it('renders without crashing', () => {
  const div = document.createElement('div');
  ReactDOM.render(<App />, div);
  ReactDOM.unmountComponentAtNode(div);
});

it('renders without crashing', () => {
  const span = document.createElement('span');
  ReactDOM.render(<App />, span);
  ReactDOM.unmountComponentAtNode(span);
});

it('renders without crashing', () => {
  const li = document.createElement('li');
  ReactDOM.render(<App />, li);
  ReactDOM.unmountComponentAtNode(li);
});
