import React, {Component, ReactElement} from "react";
import {Route, Switch} from "react-router-dom";
import UserList from "./UserList";

class UserView extends Component {
	render(): ReactElement {
		return (
			<Switch>
				<Route exact path="/users" component={UserList}/>
				<Route path="/users/:id/edit"/>
			</Switch>
		);
	}
}

export default UserView;
