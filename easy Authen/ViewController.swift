//
//  ViewController.swift
//  easy Authen
//
//  Created by Student14 on 6/13/2560 BE.
//  Copyright © 2560 SNRU. All rights reserved.
//

import UIKit

class ViewController: UIViewController {
    
    // Implicit 
    var strUser: String?
    var strPwd: String?
    let dicUser = ["master":"1234", "doramon":"5678", "nobita":"1234"]
    

    @IBOutlet weak var userTextField: UITextField!
    
    @IBOutlet weak var pwdTextField: UITextField!
    
    @IBOutlet weak var msgLabel: UILabel!
    
    @IBAction func loginButton(_ sender: Any) {
        
        
    // Get value from TextField
        strUser = userTextField.text
        strPwd = pwdTextField.text
    // Check by show get user & password succeed
    // ต้องใส่  ! FORCE UNWRAPE เพื่อขออนุญาต optional variable ตัวแปรที่มีค่าว่างได้ ปกติ iOS จะไม่ยอม
        print("user==>\(strUser!)")
        print("pwd==>\(strPwd!)")
    // how to know variable is nil, Count it !!!(Best practice ?)
        let intUser = strUser?.characters.count
        let intPwd = strPwd?.characters.count
        print("intUser==>\(intUser!)")
        print("intPwd==>\(intPwd!)")
    // Call checkSpace func
        if checkSpace(myString: strUser!) && checkSpace(myString: strPwd!)                                       {
            print("No Space")
            showMsg(strMsg: "")
            checkUserAndPwd(strUser: strUser!, strPwd: strPwd!)
       }else {
            print("Have Space")
            showMsg(strMsg: "Please Fill all form")
       }
     //   }else { msgLabel.text = "Blank user"}
    }// login button
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // finish design
        // Do any additional setup after loading the view, typically from a nib.
    }// main method

    func checkUserAndPwd(strUser: String, strPwd: String) -> Void {
        //check user
        if let testUser = dicUser[strUser]{
            print("testUser==>\(testUser)")
            if strPwd == testUser{
                // Collect password
                showMsg(strMsg: "Wellcome !!!")
            }else{
                // wrong password
                showMsg(strMsg: "Wrong password")
            }
        }else{
            print("testUser is nil ")
            showMsg(strMsg: "No "+strUser+" "+"in my database")
        }
    }
    
    
    
    
    func checkSpace(myString: String) -> Bool {
        let intString = myString.characters.count
        var result: Bool = true
        if intString == 0 {
            // Blank data
           result = false
        }
        
        return result
    }
    // Take Arg message to show on screen
    func showMsg(strMsg:String) -> Void {
        msgLabel.text = strMsg
    }
    

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    } //didReceive
    
} // main class

