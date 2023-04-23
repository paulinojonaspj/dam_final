import 'package:flutter/material.dart';

class LoginForm extends StatefulWidget {
  //const LoginForm({Key? key}) : super(key: key);

  @override
  State<LoginForm> createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(

      appBar: AppBar(title: Text("oGPT")),
  body: SingleChildScrollView(

    scrollDirection: Axis.vertical,
    child:Center(
    child: Column(
      mainAxisAlignment: MainAxisAlignment.center,

      children: const [

        SizedBox(height: 50.0,),
        Text("Login",style: TextStyle(fontWeight: FontWeight.bold, color: Colors.black, fontSize: 30.0)),
        SizedBox(height: 10.0),
      Image(image: AssetImage('assets/images/logo.png'),
      height: 150.0,
        width: 150.0,
      ),
        SizedBox(height: 15.0),
        Text("Gestão de Tarefas",style: TextStyle(fontWeight: FontWeight.bold, color: Colors.black38, fontSize: 25.0)),
        SizedBox(height: 20.0),
        TextField(
          decoration: InputDecoration(
            border: OutlineInputBorder(
              borderRadius: BorderRadius.all(Radius.circular(30.0)),
              borderSide: BorderSide(color: Colors.transparent)
            ),
            prefixIcon: Icon(Icons.person),
            filled: true,
            hintText: 'Email',
            fillColor: Colors.white38,
            focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.all(Radius.circular(30.0)),
                borderSide: BorderSide(color: Colors.blue)
            )
          ),
        ),
        SizedBox(height: 10.0),
        TextField(
          obscureText: true,
          decoration: InputDecoration(
              border: OutlineInputBorder(
                  borderRadius: BorderRadius.all(Radius.circular(30.0)),
                  borderSide: BorderSide(color: Colors.transparent)
              ),
              prefixIcon: Icon(Icons.key),
              filled: true,
              hintText: 'Password',
              fillColor: Colors.white38,
              focusedBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.all(Radius.circular(30.0)),
                  borderSide: BorderSide(color: Colors.blue)
              )
          ),
        ),
      ],
    ),
    ),
  ),

    );
  }
}
