import React, {Component, ReactElement} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Switch} from "react-router-dom";
import Home from "./Home";
import {AppBar, Tab, Tabs} from "@material-ui/core";
import UserView from "./views/user/UserView";

class App extends Component {
	public render(): ReactElement {
		return (
			<BrowserRouter>
				<AppBar title={document.title}>
					<Tabs value={false}>
						<Tab label="Benutzer"/>
						<Tab label="Software"/>
					</Tabs>
				</AppBar>
				<div>
					<Switch>
						<Route exact path='/' component={Home}/>
						<Route path='/users' component={UserView}/>
					</Switch>
				</div>
			</BrowserRouter>
		);
	}
}

ReactDOM.render(<App/>, document.getElementById('app'));
